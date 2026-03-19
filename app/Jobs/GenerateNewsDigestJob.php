<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Actions\Article\SaveAiGeneratedArticlesAction;
use App\Ai\Agents\NewsWriter;
use App\Models\Article;
use App\Notifications\NewsDigestCompletedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redis;
use JsonException;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Streaming\Events\StreamEnd;
use Laravel\Ai\Streaming\Events\TextDelta;
use Laravel\Ai\Streaming\Events\ToolCall;
use Laravel\Ai\Streaming\Events\ToolResult;
use Throwable;

final class GenerateNewsDigestJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const string CACHE_PREFIX = 'news-digest';

    public int $timeout = 600;

    public int $uniqueFor = 900;

    /**
     * @param  array<int, string>  $sources
     */
    public function __construct(
        public string $provider,
        public string $model,
        public int $batchSize,
        public array $sources,
    ) {}

    public function handle(): void
    {
        $this->reset();
        $this->setStatus('running');

        $lab = Lab::from($this->provider);
        $batches = array_chunk($this->sources, max(1, $this->batchSize));
        $totalSources = count($this->sources);
        $today = Date::now()->translatedFormat('l j F Y');
        $startTime = microtime(true);

        $this->log(['type' => 'init', 'provider' => $this->provider, 'model' => $this->model, 'sources' => $totalSources, 'passes' => count($batches)]);

        /** @var list<array{title: string, body: string, tags?: list<string>}> $allArticles */
        $allArticles = [];
        $isFirstBatch = true;

        foreach ($batches as $batchIndex => $batchSources) {
            $batchNumber = $batchIndex + 1;

            if (! $isFirstBatch) {
                $this->log(['type' => 'pause', 'seconds' => 60]);
                \Illuminate\Support\Sleep::sleep(60);
            }

            $this->log(['type' => 'pass_start', 'pass' => $batchNumber, 'total' => count($batches), 'sources' => $batchSources]);

            $sourcesList = implode("\n", array_map(
                fn (string $url): string => '- '.$url,
                $batchSources,
            ));

            $prompt = <<<PROMPT
            Effectue ta veille hebdomadaire. Voici les sources a consulter pour cette passe :

            {$sourcesList}

            Parcours chaque source, identifie les actualites recentes (derniere semaine) concernant Laravel, PHP et leur ecosysteme, puis redige le ou les articles correspondants.

            Date du jour : {$today}
            PROMPT;

            try {
                $batchStartTime = microtime(true);
                $responseText = '';

                $stream = NewsWriter::make()->stream(
                    $prompt,
                    provider: $lab,
                    model: $this->model,
                    timeout: 300,
                );

                /** @var list<string> $pendingUrls */
                $pendingUrls = [];

                foreach ($stream as $event) {
                    if ($event instanceof ToolCall) {
                        $pendingUrls[] = $event->toolCall->arguments['url'] ?? 'unknown';
                    } elseif ($event instanceof ToolResult) {
                        $url = array_shift($pendingUrls) ?? 'unknown';
                        $this->log(['type' => 'source_result', 'url' => $url, 'success' => $event->successful]);
                    } elseif ($event instanceof TextDelta) {
                        $responseText .= $event->delta;
                    } elseif ($event instanceof StreamEnd) {
                        // Stream ended for this batch
                    }
                }

                $elapsed = (int) round(microtime(true) - $batchStartTime);
                $articles = NewsWriter::parseResponse($responseText);

                if ($articles !== []) {
                    $this->log(['type' => 'pass_result', 'pass' => $batchNumber, 'count' => count($articles), 'elapsed' => $elapsed]);
                    array_push($allArticles, ...$articles);
                } else {
                    $this->log(['type' => 'pass_result', 'pass' => $batchNumber, 'count' => 0, 'elapsed' => $elapsed]);
                }
            } catch (Throwable $e) {
                $elapsed = (int) round(microtime(true) - ($batchStartTime ?? microtime(true)));
                $this->log(['type' => 'error', 'message' => mb_substr($e->getMessage(), 0, 200), 'elapsed' => $elapsed]);
            }

            $isFirstBatch = false;
        }

        $totalElapsed = (int) round(microtime(true) - $startTime);

        if ($allArticles === []) {
            $this->complete(0, $totalElapsed);

            return;
        }

        $this->log(['type' => 'saving', 'count' => count($allArticles)]);
        $saved = resolve(SaveAiGeneratedArticlesAction::class)->execute(
            $allArticles,
            fn (Article $post) => $this->log(['type' => 'article_saved', 'title' => $post->title]),
        );
        $savedCount = count($saved);

        $this->complete($savedCount, $totalElapsed);

        (new AnonymousNotifiable)->notify(
            new NewsDigestCompletedNotification($savedCount, $this->provider, $this->model)
        );
    }

    public function failed(Throwable $exception): void
    {
        $this->log(['type' => 'fatal', 'message' => mb_substr($exception->getMessage(), 0, 200)]);

        Cache::put(self::CACHE_PREFIX.':status', 'failed', now()->addSeconds(10));
        Redis::expire(self::CACHE_PREFIX.':logs', 10);
    }

    /**
     * @param  array<string, mixed>  $entry
     *
     * @throws JsonException
     */
    private function log(array $entry): void
    {
        Redis::rpush(self::CACHE_PREFIX.':logs', json_encode($entry, JSON_THROW_ON_ERROR));
        Redis::expire(self::CACHE_PREFIX.':logs', 3600);
    }

    private function complete(int $count, int $duration): void
    {
        $this->log(['type' => 'complete', 'count' => $count, 'duration' => $duration]);

        Cache::put(self::CACHE_PREFIX.':status', 'completed', now()->addSeconds(10));
        Cache::put(self::CACHE_PREFIX.':result', [
            'count' => $count,
            'duration' => $duration,
            'provider' => $this->provider,
            'model' => $this->model,
        ], now()->addSeconds(10));
        Redis::expire(self::CACHE_PREFIX.':logs', 10);
    }

    private function setStatus(string $status): void
    {
        Cache::put(self::CACHE_PREFIX.':status', $status, now()->addHour());
    }

    private function reset(): void
    {
        Redis::del(self::CACHE_PREFIX.':logs');
        Cache::forget(self::CACHE_PREFIX.':status');
        Cache::forget(self::CACHE_PREFIX.':result');
    }
}
