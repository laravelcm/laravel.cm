<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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
        } else {
            /** @var Reaction $react */
            $react = Reaction::query()->where('name', $reaction)->first();

            Auth::user()->reactTo($this->model, $react); // @phpstan-ignore-line
        }
    }

    public function render(): View
    {
        return view('livewire.components.reactions');
    }
}
