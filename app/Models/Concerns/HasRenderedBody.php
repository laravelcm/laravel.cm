<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Jobs\RenderMarkdownJob;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $body
 * @property string|null $body_html
 * @property \Illuminate\Support\Carbon|null $body_rendered_at
 */
trait HasRenderedBody
{
    public static function bootHasRenderedBody(): void
    {
        static::saved(function (Model $model): void {
            if (! $model->wasChanged('body')) {
                return;
            }

            dispatch(new RenderMarkdownJob($model));
        });
    }

    public function renderedBody(): string
    {
        if (is_string($this->body_html) && $this->body_html !== '') {
            return $this->body_html;
        }

        return md_render((string) $this->body);
    }
}
