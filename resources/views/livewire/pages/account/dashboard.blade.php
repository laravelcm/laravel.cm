<x-container class="py-12">
    <header>
        <h1 class="text-xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-2xl">
            {{ __('global.navigation.dashboard') }}
        </h1>
        <x-user.stats :user="$this->user" />
    </header>
</x-container>
