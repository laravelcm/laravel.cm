<?php

declare(strict_types=1);

namespace App\Actions;

use App\Contracts\SpamReportableContract;
use App\Exceptions\CanReportSpamException;
use App\Models\User;
use App\Notifications\ReportedSpamToTelegram;

final class ReportSpamAction
{
    public function execute(User $user, SpamReportableContract $model, ?string $content = null): void
    {
        if ($model->spamReports()->whereBelongsTo($user)->exists()) {
            throw new CanReportSpamException(
                message: __('notifications.exceptions.spam_exist'),
            );
        }

        $spam = $model->spamReports()->create([
            'user_id' => $user->id,
            'reason' => $content,
        ]);

        $user->notify(new ReportedSpamToTelegram($spam));
    }
}
