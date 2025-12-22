<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Auth;

use App\Livewire\Forms\RegisterForm;
use App\Models\User;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

/**
 * @property-read Collection<int, User> $users
 */
#[Layout('layouts.base')]
final class Register extends Component
{
    public RegisterForm $form;

    public function register(): void
    {
        $this->form->validate();

        $this->form->createUser();

        Flux::toast(
            text: __('pages/auth.register.email_verification_status'),
            heading: __('pages/auth.register.email_verification_title'),
            variant: 'success'
        );

        $this->form->reset();
    }

    #[Computed(persist: true, seconds: 3600 * 7, cache: true, key: 'registration.users')]
    public function users(): Collection
    {
        /** @var Collection<int, User> $users */
        $users = Cache::remember(
            key: 'avatars',
            ttl: now()->addWeek(),
            callback: fn (): Collection => User::query() // @phpstan-ignore-line
                ->select('id', 'email_verified_at', 'username', 'avatar_type', 'name')
                ->scopes('verifiedUsers')
                ->inRandomOrder()
                ->take(10)
                ->get()
        );

        return $users;
    }

    public function render(): View
    {
        return view('livewire.pages.auth.register')
            ->title(__('pages/auth.register.page_title'));
    }
}
