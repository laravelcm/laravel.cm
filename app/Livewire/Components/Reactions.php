<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

final class Reactions extends Component
{
    public ReactableInterface $model;

    public bool $withPlaceHolder = true;

    public bool $withBackground = true;

    public string $direction = 'horizontal';

    public function userReacted(string $reaction): void
    {
        if (Auth::guest()) {
            Flux::toast(
                text: __('Vous devez être connecté pour réagir à ce contenu!'),
                heading: __('Oh Oh! Erreur'),
                variant: 'danger',
            );

            return;
        }

        /** @var User $user */
        $user = Auth::user();

        if ($user->banned()) {
            Flux::toast(
                text: __('Votre compte est suspendu.'),
                heading: __('Oh Oh! Erreur'),
                variant: 'danger',
            );

            return;
        }

        /** @var int|string $userKey */
        $userKey = $user->getKey();
        $rateLimitKey = 'reactions:'.$userKey;

        if (RateLimiter::tooManyAttempts($rateLimitKey, maxAttempts: 30)) {
            Flux::toast(
                text: __('Trop de réactions envoyées, veuillez réessayer plus tard.'),
                variant: 'danger',
            );

            return;
        }

        $react = Reaction::query()->where('name', $reaction)->first();

        if (! $react instanceof Reaction) {
            Flux::toast(
                text: __('Type de réaction invalide.'),
                variant: 'danger',
            );

            return;
        }

        RateLimiter::hit($rateLimitKey, decaySeconds: 60);

        $user->reactTo($this->model, $react);

        $this->dispatch('liked');
    }

    public function render(): View
    {
        return view('livewire.components.reactions');
    }
}
