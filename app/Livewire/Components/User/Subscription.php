<?php

declare(strict_types=1);

namespace App\Livewire\Components\User;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Subscription extends Component
{
    public function render(): View
    {
        return view('livewire.components.user.subscription');
    }
}
