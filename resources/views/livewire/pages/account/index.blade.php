<x-layouts.account>
    <form wire:submit="save">
        <div class="space-y-10">
            <div>
                <flux:heading size="lg">{{ __('pages/account.settings.profile_title') }}</flux:heading>
                <flux:subheading class="mt-1">
                    {{ __('pages/account.settings.profile_description') }}
                </flux:subheading>
            </div>

            <div class="line-y">
                <div class="bg-dotted p-2">
                    <div
                        class="grid gap-6 rounded-lg ring-1 ring-gray-200 dark:ring-white/10 bg-white dark:bg-line-black p-6">
                        <flux:field>
                            <flux:label>{{ __('validation.attributes.avatar') }}</flux:label>
                            <flux:description>{{ __('pages/account.settings.avatar_description') }}</flux:description>

                            <div class="mt-2 flex items-center gap-4">
                                @if ($form->avatar)
                                    <img src="{{ $form->avatar->temporaryUrl() }}" alt="Avatar"
                                         class="size-16 rounded-full object-cover">
                                @elseif ($form->user?->getFirstMediaUrl('avatar'))
                                    <img src="{{ $form->user->getFirstMediaUrl('avatar') }}" alt="Avatar"
                                         class="size-16 rounded-full object-cover">
                                @else
                                    <div
                                        class="size-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <flux:icon.user class="size-10 text-gray-400 dark:text-gray-500" />
                                    </div>
                                @endif

                                <div class="flex-1 space-y-1">
                                    <div class="max-w-md">
                                        <flux:file-upload
                                            wire:model="form.avatar"
                                            accept="image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/avif"
                                        >
                                            <flux:file-upload.dropzone
                                                :heading="__('validation.attributes.dropzone')"
                                                :text="__('validation.hints.dropzone')"
                                                inline
                                            />
                                        </flux:file-upload>
                                    </div>

                                    <flux:error name="form.avatar" />
                                </div>
                            </div>
                        </flux:field>

                        <flux:input
                            :label="__('validation.attributes.username')"
                            wire:model="form.username"
                            :badge="__('validation.hints.required')"
                            placeholder="johndoe"
                            required
                        >
                            <x-slot name="prefix">
                                <span class="text-sm text-gray-500 dark:text-gray-400">laravel.cm/user/@</span>
                            </x-slot>
                        </flux:input>

                        <flux:field>
                            <div class="flex items-center justify-between gap-2">
                                <flux:label>{{ __('validation.attributes.bio') }}</flux:label>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('global.characters', ['number' => 160]) }}
                                </span>
                            </div>

                            <flux:textarea class="mt-2" wire:model="form.bio" rows="3" />

                            <flux:description>
                                {{ __('pages/account.settings.bio_description') }}
                            </flux:description>
                        </flux:field>

                        <flux:input
                            :label="__('validation.attributes.website')"
                            wire:model="form.website"
                            type="url"
                            placeholder="https://laravel.cm"
                        >
                            <x-slot name="icon">
                                <x-untitledui-globe class="size-5" aria-hidden="true" />
                            </x-slot>
                        </flux:input>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-10 pt-10 line-b">
            <div>
                <flux:heading size="lg">{{ __('pages/account.settings.personal_information_title') }}</flux:heading>
                <flux:subheading class="mt-1">
                    {{ __('pages/account.settings.personal_information_description') }}
                </flux:subheading>
            </div>

            <div class="line-y">
                <div class="bg-dotted p-2">
                    <div
                        class="grid gap-6 rounded-lg ring-1 ring-gray-200 dark:ring-white/10 bg-white dark:bg-line-black p-6">
                        <flux:input
                            wire:model="form.name"
                            :label="__('validation.attributes.name')"
                            :badge="__('validation.hints.required')"
                            required
                        />

                        <flux:field>
                            <flux:input
                                wire:model="form.email"
                                :label="__('validation.attributes.email')"
                                :badge="__('validation.hints.required')"
                                type="email"
                                required
                            >
                                <x-slot name="iconTrailing">
                                    @if ($form->user?->hasVerifiedEmail())
                                        <x-heroicon-m-check-circle class="size-5 text-green-500" aria-hidden="true" />
                                    @else
                                        <x-heroicon-m-exclamation-triangle class="size-5 text-yellow-500"
                                                                           aria-hidden="true" />
                                    @endif
                                </x-slot>
                            </flux:input>

                            @if (!$form->user?->hasVerifiedEmail())
                                <flux:description>
                                    {{ __('pages/account.settings.unverified_mail') }}
                                </flux:description>
                            @endif

                            <flux:error name="form.email" />
                        </flux:field>

                        <flux:input
                            wire:model="form.location"
                            :label="__('validation.attributes.location')"
                            placeholder="Douala, Cameroun"
                        />

                        <flux:input
                            wire:model="form.phone_number"
                            :label="__('validation.attributes.phone')"
                            type="tel"
                            placeholder="+237 6XX XXX XXX"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-10 pt-10 line-b">
            <div>
                <flux:heading size="lg">{{ __('pages/account.settings.social_network_title') }}</flux:heading>
                <flux:subheading class="mt-1">
                    {{ __('pages/account.settings.social_network_description') }}
                </flux:subheading>
            </div>

            <div class="line-y">
                <div class="bg-dotted p-2">
                    <div
                        class="grid gap-6 rounded-lg ring-1 ring-gray-200 dark:ring-white/10 bg-white dark:bg-line-black p-6">
                        <flux:input
                            wire:model.blur="form.github_profile"
                            label="GitHub"
                            placeholder="laravelcm"
                        >
                            <x-slot name="icon">
                                <x-icon.github class="size-5" aria-hidden="true" />
                            </x-slot>
                        </flux:input>

                        <flux:input
                            wire:model="form.twitter_profile"
                            label="Twitter"
                            placeholder="laravelcm"
                            :description="__('pages/account.settings.twitter_helper_text')"
                        >
                            <x-slot name="icon">
                                <x-phosphor-x-logo-duotone class="size-5" aria-hidden="true" />
                            </x-slot>
                        </flux:input>

                        <flux:field>
                            <flux:input wire:model="form.linkedin_profile" label="LinkedIn" placeholder="laravelcm">
                                <x-slot name="icon">
                                    <x-phosphor-linkedin-logo-fill class="size-5" aria-hidden="true" />
                                </x-slot>
                            </flux:input>

                            <flux:description>
                                <span class="inline-flex items-center gap-1">
                                    <flux:badge size="sm" color="gray">linkedin.com/in/{votre-pseudo}</flux:badge>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('pages/account.settings.linkedin_helper_text') }}
                                    </span>
                                </span>
                            </flux:description>

                            <flux:error name="form.linkedin_profile" />
                        </flux:field>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end mt-10">
            <flux:button type="submit" variant="primary" class="border-0">
                {{ __('actions.save') }}
            </flux:button>
        </div>
    </form>
</x-layouts.account>
