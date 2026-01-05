<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Actions\ReportSpamAction;
use App\Contracts\SpamReportableContract;
use App\Exceptions\CanReportSpamException;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ReportSpam extends Component
{
    public SpamReportableContract $model;

    public ?string $reason = null;

    public function confirmReport(): void
    {
        $this->authorize('report', $this->model);

        Flux::modal('confirm-report-spam')->show();
    }

    public function report(): void
    {
        $this->authorize('report', $this->model);
        /** @var User $user */
        $user = Auth::user();

        try {
            resolve(ReportSpamAction::class)->execute(
                user: $user,
                model: $this->model,
                content: $this->reason,
            );

            Flux::toast(
                text: __('notifications.spam_send'),
                variant: 'success'
            );

            $this->reset('reason');

            Flux::modal('confirm-report-spam')->close();
        } catch (CanReportSpamException $canReportSpamException) {
            Flux::toast(
                text: $canReportSpamException->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function render(): View
    {
        return view('livewire.components.report-spam');
    }
}
