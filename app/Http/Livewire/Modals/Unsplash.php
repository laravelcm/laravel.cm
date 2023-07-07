<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use Illuminate\Contracts\View\View;
use LivewireUI\Modal\ModalComponent;

final class Unsplash extends ModalComponent
{
    public ?string $query = null;

    public ?string $username = null;

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render(): View
    {
        return view('livewire.modals.unsplash');
    }
}
