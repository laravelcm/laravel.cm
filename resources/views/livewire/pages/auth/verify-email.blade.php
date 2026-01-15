<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new class extends Component
{
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard.index', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="section-gradient">
    <x-container class="px-0 lg:line-x">
        <div class="py-20 lg:py-32 flex flex-col items-center justify-center xl:py-56">
            <div class="w-full max-w-md lg:max-w-lg">
                <p class="text-gray-700 dark:text-gray-300">
                    {{ __('pages/auth.verify.description') }}
                </p>

                <div class="mt-8 space-y-6">
                    @if (session('status') == 'verification-link-sent')
                        <flux:callout
                            variant="success"
                            icon="check-circle"
                            :heading="__('pages/auth.verify.success')"
                        />
                    @endif

                    <div class="flex items-center justify-between">
                        <flux:button variant="primary" wire:click="sendVerification" class="border-0">
                            {{ __('pages/auth.verify.submit') }}
                        </flux:button>

                        <form wire:submit="logout">
                            <button
                                type="submit"
                                class="text-sm text-gray-500 dark:text-gray-300 underline decoration-1 decoration-dotted hover:text-gray-900 focus:outline-hidden dark:hover:text-white"
                            >
                                {{ __('global.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</section>
