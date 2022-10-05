<?php

namespace App\Http\Livewire;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reactions extends Component
{
    public ReactableInterface $model;

    public bool $withPlaceHolder = true;

    public bool $withBackground = true;

    public string $direction = 'right';

    public function userReacted(string $reaction): void
    {
        if (Auth::guest()) {
            // @ToDo mettre un nouveau system de notification
//            $this->notification()->error(
//                'Oh Oh! Erreur',
//                'Vous devez être connecté pour réagir à ce contenu!'
//            );
        } else {
            /** @var Reaction $react */
            $react = Reaction::query()->where('name', $reaction)->first();
            Auth::user()->reactTo($this->model, $react);
        }
    }

    public function render(): View
    {
        return view('livewire.reactions');
    }
}
