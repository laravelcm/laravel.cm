<?php

declare(strict_types=1);

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    <button
        wire:click="logout"
        class="group flex w-full items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white"
        tabindex="-1"
    >
        <x-icon.logout
            class="hidden size-5 text-gray-400 dark:gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300 lg:block"
            stroke-width="1.5"
            aria-hidden="true"
        />
        {{ __('global.logout') }}
    </button>
</div>
