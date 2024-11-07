<x-app-layout :title="__('pages/auth.reset.page_title')">
    <div class="flex min-h-full items-center justify-center py-16 sm:py-24">
        <div class="w-full max-w-md">
            <h2 class="text-center font-heading text-3xl font-bold text-gray-900 sm:text-left">
                {{ __('pages/auth.reset.page_title') }}
            </h2>

            <form action="{{ route('password.update') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                <div>
                    <x-label for="email-address">
                        {{ __('validation.attributes.email') }}
                    </x-label>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="text"
                            id="email-address"
                            name="email"
                            autocomplete="email"
                            required="true"
                            :value="old('email', $request->email)"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-label for="password">
                        {{ __('validation.attributes.password') }}
                    </x-label>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            id="password"
                            name="password"
                            required="true"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div>
                    <x-label for="password_confirmation">
                        {{ __('validation.attributes.password_confirmation') }}
                    </x-label>
                    <x-filament::input.wrapper>
                        <x-filament::input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            required="true"
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <x-buttons.submit>
                        {{ __('pages/auth.reset.submit') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </div>

    <x-join-sponsors :title="__('global.sponsor_thanks')" />
</x-app-layout>
