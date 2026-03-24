<?php

declare(strict_types=1);

namespace Laravelcm\Sentinel\Enums;

enum IssueStatus: string
{
    case Detected = 'detected';
    case Notified = 'notified';
    case Resolved = 'resolved';
    case AutoFixed = 'auto_fixed';
}
