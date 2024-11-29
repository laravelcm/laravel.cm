<?php

declare(strict_types=1);

namespace App\Livewire\Discussions;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

final class ConvertedToThread
{
    use AuthorizesRequests;

    public Discussion $discussion;

    public function convertDiscution(): void
    {
        $this->authorize(DiscussionPolicy::CONVERTEDTOTHREAD, $this->discussion);

        $this->discussion->subscribes()
            ->where('user_id', Auth::id())
            ->delete();

        Notification::make()
            ->title(__('Désabonnement'))
            ->body(__('Vous êtes maintenant désabonné à cette discussion.'))
            ->success()
            ->duration(5000)
            ->send();

        $this->dispatch('refresh')->self();
    }
}
