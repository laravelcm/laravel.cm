<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Traits\WithInfiniteScroll;
use Livewire\Component;

class Articles extends Component
{
    use WithInfiniteScroll;

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.user.articles', [
            'articles' => $this->user
                ->articles()
                ->published()
                ->paginate($this->perPage),
        ]);
    }
}
