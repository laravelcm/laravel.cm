<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Account;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Settings extends Component
{
    public function render(): View
    {
        return view('livewire.pages.account.settings')
            ->title(__('global.navigation.settings'));
    }
}
