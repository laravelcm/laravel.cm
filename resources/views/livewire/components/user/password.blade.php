<div>
    <x-setting-heading
        :title="__('global.navigation.password')"
        :description="__('pages/account.settings.password_description')"
    />

    <form wire:submit="changePassword" class="mt-10 max-w-2xl">
        {{ $this->form }}

        <x-buttons.submit :title="__('actions.save')" class="mt-10" />
    </form>
</div>
