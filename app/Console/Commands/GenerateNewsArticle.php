<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\Article\SaveAiGeneratedArticlesAction;
use App\Ai\Agents\NewsWriter;
use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Streaming\Events\StreamEnd;
use Laravel\Ai\Streaming\Events\TextDelta;
use Laravel\Ai\Streaming\Events\ToolCall;
use Laravel\Ai\Streaming\Events\ToolResult;
use Throwable;

use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\spin;
use function Laravel\Prompts\warning;

final class GenerateNewsArticle extends Command
{
    protected $signature = 'ai:news-digest
        {--dry-run : Preview generated articles without saving to database}
        {--batch=4 : Number of sources to process per pass}
        {--timeout=300 : Timeout in seconds per batch}
        {--delay=60 : Delay in seconds between batches to avoid rate limiting}
        {--provider=anthropic : AI provider (anthropic, openai)}
        {--model=claude-haiku-4-5-20251001 : AI model to use}';

    protected $description = 'Crawl configured tech sources and generate weekly news articles for editorial review';

    public function handle(): int
    {
        $batchSize = (int) $this->option('batch');
        $timeout = (int) $this->option('timeout');
        $delay = (int) $this->option('delay');
        $provider = Lab::from((string) $this->option('provider'));
        $model = (string) $this->option('model');
        $batches = array_chunk($this->sources(), max(1, $batchSize));
        $totalSources = count($this->sources());
        $today = Date::now()->translatedFormat('l j F Y');

        info(sprintf('Veille hebdomadaire — %d sources en ', $totalSources).count($batches).' passes');
        note(sprintf('Provider: %s | Modèle: %s | Batch: %d | Timeout: %ds | Délai: %ds', $provider->value, $model, $batchSize, $timeout, $delay));

        $this->newLine();

        /** @var list<array{title: string, body: string, tags?: list<string>}> $allArticles */
        $allArticles = [];

        $totalBatches = count($batches);
        $isFirstBatch = true;

        foreach ($batches as $batchIndex => $batchSources) {
            $batchNumber = $batchIndex + 1;

            // Pause between batches to avoid the rate limit
            if (! $isFirstBatch && $delay > 0) {
                spin(
                    callback: fn (): int => sleep($delay),
                    message: sprintf('Pause de %ds avant la passe suivante (rate limit)...', $delay)
                );

                $this->newLine();
            }

            $this->components->twoColumnDetail(
                sprintf('Passe %d/%d', $batchNumber, $totalBatches),
                '<fg=gray>'.count($batchSources).' sources</>'
            );

            foreach ($batchSources as $source) {
                $this->line(sprintf('  <fg=gray>→ %s</>', $source));
            }

            $this->newLine();

            $prompt = NewsWriter::buildPrompt($batchSources, $today);

            try {
                $startTime = microtime(true);
                $responseText = '';

                $stream = NewsWriter::make()->stream(
                    $prompt,
                    provider: $provider,
                    model: $model,
                    timeout: $timeout,
                );

                /** @var list<string> $pendingUrls */
                $pendingUrls = [];

                foreach ($stream as $event) {
                    if ($event instanceof ToolCall) {
                        $pendingUrls[] = $event->toolCall->arguments['url'] ?? 'unknown';
                    } elseif ($event instanceof ToolResult) {
                        $url = array_shift($pendingUrls) ?? 'unknown';
                        $this->components->twoColumnDetail(
                            '  '.$url,
                            $event->successful
                                ? '<fg=green;options=bold>DONE</>'
                                : '<fg=red>FAILED</>'
                        );
                    } elseif ($event instanceof TextDelta) {
                        $responseText .= $event->delta;
                        $this->output->write('<fg=gray>.</>');
                    } elseif ($event instanceof StreamEnd) {
                        $this->newLine();
                    }
                }

                $elapsed = (int) round(microtime(true) - $startTime);
                $this->newLine();

                $batchArticles = NewsWriter::parseResponse($responseText);

                if ($batchArticles !== []) {
                    $this->components->twoColumnDetail(
                        '  Résultat',
                        sprintf('<fg=green>%d article(s) trouvé(s)</> <fg=gray>(%ds)</>', count($batchArticles), $elapsed)
                    );
                    array_push($allArticles, ...$batchArticles);
                } else {
                    $this->components->twoColumnDetail(
                        '  Résultat',
                        sprintf('<fg=yellow>Rien de nouveau</> <fg=gray>(%ds)</>', $elapsed)
                    );
                }
            } catch (Throwable $e) {
                $elapsed = (int) round(microtime(true) - ($startTime ?? microtime(true)));
                $message = mb_substr($e->getMessage(), 0, 120);
                $this->components->twoColumnDetail(
                    '  Erreur',
                    sprintf('<fg=red>%s</> <fg=gray>(%ds)</>', $message, $elapsed)
                );
            }

            $this->newLine();
            $isFirstBatch = false;
        }

        if (blank($allArticles)) {
            warning('Aucun article généré cette semaine.');

            return self::SUCCESS;
        }

        info(count($allArticles).' article(s) généré(s) au total');
        $this->newLine();

        if ($this->option('dry-run')) {
            return $this->previewArticles($allArticles);
        }

        return $this->saveArticles($allArticles);
    }

    /**
     * @return list<string>
     */
    private function sources(): array
    {
        /** @var list<string> */
        return config('lcm.news_digest.default_sources', []);
    }

    /**
     * @param  list<array{title: string, body: string, tags?: list<string>}>  $articles
     */
    private function previewArticles(array $articles): int
    {
        foreach ($articles as $i => $article) {
            $this->components->twoColumnDetail(
                'Article #'.($i + 1),
                $article['title'],
            );
            $this->newLine();
            $this->line('  '.mb_substr($article['body'], 0, 500).'...');
            $this->newLine();
        }

        info('Dry run terminé — aucun article sauvegardé.');

        return self::SUCCESS;
    }

    /**
     * @param  list<array{title: string, body: string, tags?: list<string>}>  $articles
     */
    private function saveArticles(array $articles): int
    {
        info('Sauvegarde des articles...');

        $saved = resolve(SaveAiGeneratedArticlesAction::class)->execute(
            $articles,
            function (Article $post): void {
                $this->components->twoColumnDetail(
                    $post->title,
                    '<fg=yellow>En attente de validation</>',
                );
            },
        );

        $this->newLine();
        info(count($saved).' article(s) soumis pour validation éditoriale.');

        return self::SUCCESS;
    }
}
