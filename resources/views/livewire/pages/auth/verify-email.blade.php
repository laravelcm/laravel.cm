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

<div>
    <div class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div class="mt-6 w-full sm:max-w-md lg:mt-10 lg:max-w-xl">
            <p class="mb-4 text-center text-sm text-gray-500 dark:text-gray-400">
                {{ __('pages/auth.verify.description') }}
            </p>

            <div class="mt-8 overflow-hidden">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 rounded-lg bg-green-50 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <x-heroicon-s-check-circle class="size-5 text-green-400" aria-hidden="true" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    {{ __('pages/auth.verify.success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <form wire:click="sendVerification">
                        <x-buttons.submit :title="__('pages/auth.verify.submit')" wire:loading.attr="data-loading" />
                    </form>

                    <form wire:click="logout">
                        <button
                            type="submit"
                            class="text-sm text-gray-500 dark:text-gray-400 underline hover:text-gray-900 focus:outline-hidden"
                        >
                            {{ __('global.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-sponsors :title="__('global.sponsor_thanks')" />
</div>
