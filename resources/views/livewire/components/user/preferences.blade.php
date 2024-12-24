<div>
    <x-setting-heading
        :title="__('pages/account.settings.preferences_title')"
        :description="__('pages/account.settings.preferences_description')"
    />

    <form wire:submit="save" class="mt-10 max-w-xs space-y-10">
        {{ $this->form }}

        <x-buttons.submit
            :title="__('actions.save')"
            wire:loading.attr="data-loading"
        />
    </form>
</div>
