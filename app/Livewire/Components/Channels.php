<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Channels extends Component
{
    public function render(): View
    {
        return view('livewire.components.channels');
    }
}
