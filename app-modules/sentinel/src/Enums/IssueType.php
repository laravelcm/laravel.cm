<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Enums;

enum IssueType: string
{
    case BrokenCanonical = 'broken_canonical';
    case MissingHttps = 'missing_https';
    case FailedUpload = 'failed_upload';
}
