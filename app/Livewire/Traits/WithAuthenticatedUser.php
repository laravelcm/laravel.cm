<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Auth;

trait WithAuthenticatedUser
{
    public function boot(): void
    {
        if (! Auth::check()) {
            redirect()->setIntendedUrl(url()->previous());
            $this->redirect(route('login'), navigate: true);
        }
    }
}
