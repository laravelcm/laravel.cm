<?php

namespace App\Http\Livewire;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Reactions extends Component
{
    use Actions;

    public Model $model;

    public bool $withPlaceHolder = true;

    public bool $withBackground = true;

    public string $direction = 'right';

    public function userReacted(string $reaction)
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

    public function render()
    {
        return view('livewire.reactions');
    }
}
