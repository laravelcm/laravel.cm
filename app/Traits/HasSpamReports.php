<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SpamReport;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasSpamReports
{
    public function spamReports(): MorphMany
    {
        return $this->morphMany(SpamReport::class, 'reportable');
    }
}
