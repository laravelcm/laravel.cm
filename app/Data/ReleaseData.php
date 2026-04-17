<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;

final class ReleaseData extends Data
{
    /**
     * @param  Collection<int, ContributorData>  $contributors
     */
    public function __construct(
        public string $tag_name,
        public string $name,
        public string $body,
        public string $html_url,
        public Carbon $published_at,
        public ReleaseAuthorData $author,
        #[DataCollectionOf(ContributorData::class)]
        public Collection $contributors,
        public bool $prerelease = false,
    ) {}
}
