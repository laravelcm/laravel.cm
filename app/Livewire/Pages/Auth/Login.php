<?php

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Layout;

// #[Layout('layouts.guest')]
class Login extends Component
{
    public LoginForm $form;

    public function boot()
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

    public function render()
    {
        return view('livewire.pages.auth.login');
    }
}