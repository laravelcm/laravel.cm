<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class DiscussionForm extends Component
{
    public function render(): View
    {
        return view('livewire.components.slideovers.discussion-form');
    }
}
