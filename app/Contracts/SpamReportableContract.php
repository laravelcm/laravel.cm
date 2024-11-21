<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface SpamReportableContract
{
    public function getPathUrl(): string;

    public function spamReports(): MorphMany;
}
