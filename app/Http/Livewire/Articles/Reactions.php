<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Reactions extends Component
{
    public Article $article;

    public function userReacted(string $reaction)
    {
        if (Auth::guest()) {
            $this->dispatchBrowserEvent('notify', [
                'title' => 'Oh Oh!',
                'status' => 'error',
                'message' => 'Vous devez être connecté pour réagir aux articles!',
            ]);
        } else {
            $react = Reaction::where('name', $reaction)->first();
            Auth::user()->reactTo($this->article, $react);
        }
    }

    public function render()
    {
        return view('livewire.articles.reactions');
    }
}
