<div x-data class="py-8">
    <div class="flex items-center gap-4">
        <x-buttons.primary @click="$dispatch('open-modal', { id: 'sponsoring' })">
            {{ __('pages/sponsoring.sponsor') }}
        </x-buttons.primary>
        <a href="https://github.com/sponsors/mckenziearts" target="_blank" class="inline-flex justify-center gap-2 py-2 px-4 bg-white border-0 ring-1 ring-gray-200 dark:ring-white/20 rounded-lg shadow-sm text-sm text-gray-700 hover:text-gray-900 dark:text-gray-400 hover:bg-white/50 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-green-500 dark:bg-gray-800 dark:focus:ring-offset-gray-900">
            <x-icon.github class="size-5 text-gray-400 dark:text-gray-500" aria-hidden="true" />
            {{ __('pages/sponsoring.sponsor_github') }}
        </a>
    </div>
    <div class="mt-8">
        <p class="font-medium text-gray-900 dark:text-white text-sm">
            {{ __('pages/sponsoring.current_support') }}
        </p>
        <div class="mt-6 flex items-center flex-wrap gap-1">
            @foreach ($sponsors as $sponsor)
                <x-sponsor-profile :sponsor="$sponsor" />
            @endforeach
        </div>
    </div>

    <!-- Sponsoring Modal -->
    <template x-teleport="#main-site">
        <x-filament::modal id="sponsoring" width="2xl">
            <x-slot name="heading">
                {{ __('pages/sponsoring.title') }}
            </x-slot>

            <form wire:submit="submit">
                {{ $this->form }}

                <div class="mt-10 flex items-center justify-end gap-4">
                    <x-buttons.default @click="$dispatch('close-modal', { id: 'sponsoring' })" type="button">
                        {{ __('actions.cancel') }}
                    </x-buttons.default>
                    <x-buttons.submit
                        :title="__('pages/sponsoring.sponsor')"
                        wire:target="submit"
                        wire:loading.attr="data-loading"
                    />
                </div>
            </form>
        </x-filament::modal>
    </template>
</div>
