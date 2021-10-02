<?php

namespace App\Http\Livewire;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reactions extends Component
{
    public Model $model;

    public function userReacted(string $reaction)
    {
        if (Auth::guest()) {
            $this->dispatchBrowserEvent('notify', [
                'title' => 'Oh Oh!',
                'status' => 'error',
                'message' => 'Vous devez être connecté pour réagir à ce contenu!',
            ]);
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
