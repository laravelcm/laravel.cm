<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

final class CreateArticleData extends Data
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $body,
        public string $showToc,
        public string $canonicalUrl,
        public ?Carbon $publishedAt,
        public ?Carbon $submittedAt,
        public ?Carbon $approvedAt,
        public ?UploadedFile $file,
        public array $tags = [],
    ) {}
}
