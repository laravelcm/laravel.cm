<?php

namespace App\Http\Livewire;

use App\Contracts\ReactableInterface;
use App\Models\Reaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Reactions extends Component
{
    use Actions;

    public ReactableInterface $model;

    public bool $withPlaceHolder = true;

    public bool $withBackground = true;

    public string $direction = 'right';

    public function userReacted(string $reaction): void
    {
        if (Auth::guest()) {
            $this->notification()->error(
                'Oh Oh! Erreur',
                'Vous devez être connecté pour réagir à ce contenu!'
            );
        } else {
            $react = Reaction::where('name', $reaction)->first();
            Auth::user()->reactTo($this->model, $react);
        }
    }

    public function render(): View
    {
        return view('livewire.reactions');
    }
}
