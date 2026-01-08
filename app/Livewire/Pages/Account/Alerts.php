<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use App\Actions\Subscription\UnsubscribeToFeedAction;
use App\Models\Discussion;
use App\Models\Subscribe;
use App\Models\Thread;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class Alerts extends Component
{
    public function unsubscribe(string $subscribeId): void
    {
        resolve(UnsubscribeToFeedAction::class)->execute($subscribeId);

        Flux::toast(
            text: __('Vous êtes maintenant désabonné de cet fil.'),
            heading: __('Désabonnement'),
            variant: 'success',
        );

        $this->redirectRoute('account.alerts', navigate: true);
    }

    public function redirectToSubscription(int $id, string $type): void
    {
        $subscribe = Subscribe::query()
            ->where('subscribeable_id', $id)
            ->where('subscribeable_type', $type)
            ->firstOrFail();

        /** @var Discussion|Thread $subscribeAble */
        $subscribeAble = $subscribe->subscribeAble;

        $this->redirect(route_to_reply_able($subscribeAble), navigate: true);
    }

    public function render(): View
    {
        /** @var User $user */
        $user = Auth::user()?->load('subscriptions');

        return view('livewire.pages.account.alerts', [
            'subscriptions' => Cache::remember(
                key: 'user.'.$user->id.'.subscriptions',
                ttl: now()->addMonth(),
                callback: fn (): Collection => $user->subscriptions
            ),
        ])
            ->title(__('global.navigation.alerts'));
    }
}
