<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\LoginForm;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.base')]
final class Login extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: true);
    }

    public function render(): View
    {
        return view('livewire.pages.auth.login')
            ->title(__('pages/auth.login.page_title'));
    }
}
