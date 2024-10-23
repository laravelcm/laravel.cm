<?php

declare(strict_types=1);

namespace App\Livewire\Components\Slideovers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Laravelcm\LivewireSlideOvers\SlideOverComponent;

final class ThreadForm extends SlideOverComponent
{
    public function mount(): void
    {
        if (! Auth::check()) {
            $this->redirect(route('login'), navigate: true);
        }
    }

    public static function panelMaxWidth(): string
    {
        return '2xl';
    }

    public function render(): View
    {
        return view('livewire.components.slideovers.thread-form');
    }
}
