<div>
    <x-setting-heading
        :title="__('pages/account.settings.preferences_title')"
        :description="__('pages/account.settings.preferences_description')"
    />

    <form wire:submit="save" class="mt-10 max-w-2xl space-y-4">
        <x-theme-selector class="mt-3" :$theme />

        {{ $this->form }}

        <x-buttons.submit :title="__('actions.save')" wire:loading.attr="data-loading" class="mt-10" />
    </form>
</div>
