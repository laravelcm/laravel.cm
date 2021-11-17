<?php

namespace App\Http\Livewire\Discussions;

use App\Models\Discussion;
use Livewire\Component;

class Edit extends Component
{
    public Discussion $discussion;

    public function render()
    {
        return view('livewire.discussions.edit');
    }
}
