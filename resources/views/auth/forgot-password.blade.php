<x-app-layout :title="__('pages/auth.forgot.page_title')">
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">
            <div>
                <x-status-message class="mb-5" />

                <h2 class="text-center font-heading text-3xl font-extrabold text-gray-900 dark:text-white sm:text-left">
                    {{ __('pages/auth.forgot.page_title') }}
                </h2>
                <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('pages/auth.forgot.description') }}
                </div>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="mt-8">
                @csrf

                <div class="block">
                    <x-label for="email">{{ __('validation.attributes.email') }}</x-label>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email"
                            name="email"
                            autocomplete="email"
                            required="true"
                            :value="old('email')"
                            autofocus="true"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.submit class="relative w-full">
                        {{ __('pages/auth.forgot.title') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </div>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</x-app-layout>
