<?php

declare(strict_types=1);

namespace App\Enums;

enum NewsDigestCacheKey: string
{
    case Status = 'news-digest:status';
    case Result = 'news-digest:result';
    case Logs = 'news-digest:logs';
}
