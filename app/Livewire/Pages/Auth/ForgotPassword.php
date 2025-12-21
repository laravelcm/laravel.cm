<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Auth;

use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.base')]
final class ForgotPassword extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate();

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        Flux::toast(text: __($status), variant: 'success');
    }

    public function render(): View
    {
        return view('livewire.pages.auth.forgot-password')
            ->title(__('pages/auth.forgot.page_title'));
    }
}
