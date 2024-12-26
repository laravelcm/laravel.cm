<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Sponsoring extends Component
{
    public function render(): View
    {
        return view('livewire.pages.sponsoring')->title(__('pages/sponsoring.title'));
    }
}
