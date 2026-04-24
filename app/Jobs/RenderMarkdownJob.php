<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Markdown\MarkdownRenderer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

#[\Illuminate\Queue\Attributes\Timeout(30)]
#[\Illuminate\Queue\Attributes\Tries(3)]
final class RenderMarkdownJob implements ShouldBeUnique, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public Model $model) {}

    public function uniqueId(): string
    {
        /** @var int|string $key */
        $key = $this->model->getKey();

        return $this->model::class.':'.$key;
    }

    public function handle(MarkdownRenderer $renderer): void
    {
        /** @var string|null $body */
        $body = $this->model->getAttribute('body');

        if ($body === null || $body === '') {
            return;
        }

        $this->model->forceFill([
            'body_html' => $renderer->renderWithoutCache($body),
            'body_rendered_at' => now(),
        ])->saveQuietly();
    }
}
