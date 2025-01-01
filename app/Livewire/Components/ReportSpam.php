<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Actions\ReportSpamAction;
use App\Contracts\SpamReportableContract;
use App\Exceptions\CanReportSpamException;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ReportSpam extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public SpamReportableContract $model;

    public ?string $reason = null;

    public function reportAction(): Action
    {
        return Action::make('report')
            ->color('danger')
            ->badge()
            ->label(__('pages/forum.report_spam'))
            ->authorize('report', $this->model) // @phpstan-ignore-line
            ->requiresConfirmation()
            ->action(function (): void {
                try {
                    app(ReportSpamAction::class)->execute(
                        user: Auth::user(), // @phpstan-ignore-line
                        model: $this->model,
                        content: $this->reason,
                    );

                    Notification::make()
                        ->title(__('notifications.spam_send'))
                        ->success()
                        ->duration(3500)
                        ->send();

                    $this->reset('reason');
                } catch (CanReportSpamException $e) {
                    Notification::make()
                        ->title($e->getMessage())
                        ->danger()
                        ->duration(3500)
                        ->send();
                }
            });
    }

    public function render(): View
    {
        return view('livewire.components.report-spam');
    }
}
