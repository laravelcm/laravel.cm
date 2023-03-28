<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use LivewireUI\Modal\ModalComponent;

class Unsplash extends ModalComponent
{
    public ?string $query = null;

    public ?string $username = null;

    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function render()
    {
        return view('livewire.modals.unsplash');
    }
}
