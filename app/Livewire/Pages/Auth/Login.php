<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Auth;

use Illuminate\View\View;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

// #[Layout('layouts.guest')]
final class Login extends Component
{
    public LoginForm $form;

    public function boot(): void
    {
        $this->form = new LoginForm($this);
    }

    public function login(): void
    {
        $this->validate([
            'form.email' => ['required', 'email'],
            'form.password' => ['required'],
            'form.remember' => ['boolean'],
        ]);

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(route('dashboard'));
    }

    public function render(): View
    {
        return view('livewire.pages.auth.login');
    }
}
