<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Reactions extends Component
{
    public ReactableInterface $model;

    public bool $withPlaceHolder = true;

    public bool $withBackground = true;

    public string $direction = 'right';

    public function userReacted(string $reaction): void
    {
        if (Auth::guest()) {
            Notification::make()
                ->title(__('Oh Oh! Erreur'))
                ->body(__('Vous devez être connecté pour réagir à ce contenu!'))
                ->danger()
                ->duration(5000)
                ->send();
        } else {
            /** @var Reaction $react */
            $react = Reaction::query()->where('name', $reaction)->first();
            Auth::user()->reactTo($this->model, $react); // @phpstan-ignore-line
        }
    }

    public function render(): View
    {
        return view('livewire.reactions');
    }
}
