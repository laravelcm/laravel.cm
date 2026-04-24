<?php

declare(strict_types=1);

namespace App\Console\Commands\Content;

use App\Jobs\RenderMarkdownJob;
use App\Markdown\MarkdownRenderer;
use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

final class RerenderContentCommand extends Command
{
    /**
     * @var array<string, class-string<Model>>
     */
    private const array MODELS = [
        'article' => Article::class,
        'thread' => Thread::class,
        'discussion' => Discussion::class,
        'reply' => Reply::class,
    ];

    protected $signature = 'content:rerender
        {--model= : Only rerender a specific model (article|thread|discussion|reply)}
        {--sync : Run the renderer synchronously instead of dispatching to the queue}
        {--limit= : Limit the number of records to rerender}';

    protected $description = 'Rerender body_html for all markdown content (passes each record through the sanitizer).';

    public function handle(): int
    {
        $targetModel = $this->option('model');
        $sync = (bool) $this->option('sync');
        $limit = $this->option('limit') !== null ? (int) $this->option('limit') : null;

        $models = $targetModel !== null
            ? array_filter([self::MODELS[$targetModel] ?? null])
            : array_values(self::MODELS);

        if ($models === []) {
            $this->error('Invalid --model value. Use: '.implode('|', array_keys(self::MODELS)));

            return self::INVALID;
        }

        foreach ($models as $class) {
            $this->renderModel($class, $sync, $limit);
        }

        return self::SUCCESS;
    }

    /**
     * @param  class-string<Model>  $class
     */
    private function renderModel(string $class, bool $sync, ?int $limit): void
    {
        $query = $class::query()->whereNotNull('body');

        if ($limit !== null) {
            $query->limit($limit);
        }

        $total = (clone $query)->count();

        $this->info(sprintf('Rerendering %d records of %s', $total, class_basename($class)));

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $renderer = resolve(MarkdownRenderer::class);

        $query->chunkById(200, function ($records) use ($sync, $bar, $renderer): void {
            foreach ($records as $record) {
                if ($sync) {
                    (new RenderMarkdownJob($record))->handle($renderer);
                } else {
                    dispatch(new RenderMarkdownJob($record));
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
    }
}
