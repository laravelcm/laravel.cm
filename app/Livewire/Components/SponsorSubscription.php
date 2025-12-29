<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Forms\SponsorForm;
use App\Models\Transaction;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Throwable;

final class SponsorSubscription extends Component
{
    public SponsorForm $form;

    public function mount(): void
    {
        $this->form->setUser(Auth::user());
    }

    public function submit(): void
    {
        $this->form->validate();

        try {
            $this->redirect($this->form->support());
        } catch (Throwable $throwable) {
            Log::error($throwable->getMessage());

            Notification::make()
                ->title(__('notifications.sponsor_error_title'))
                ->body(__('notifications.sponsor_error_body'))
                ->danger()
                ->send();
        }
    }

    /**
     * @return Collection<int, Transaction>
     */
    #[Computed(seconds: 3600 * 24 * 30, cache: true, key: 'sponsors')]
    public function sponsors(): Collection
    {
        /** @var Collection<int, Transaction> $transactions */
        $transactions = Transaction::with(['user', 'user.media']) // @phpstan-ignore-line
            ->scopes('complete')
            ->get(['id', 'user_id', 'metadata']);

        return $transactions->unique(function (Transaction $transaction): string|int {
            /** @var string $email */
            $email = data_get($transaction->metadata, 'merchant.email');

            return $email ?: $transaction->user_id;
        });
    }

    public function render(): View
    {
        return view('livewire.components.sponsor-subscription');
    }
}
