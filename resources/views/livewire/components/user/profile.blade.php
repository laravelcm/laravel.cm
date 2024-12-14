<form wire:submit="save">
    {{ $this->form }}

    <div class="mt-8 flex items-center justify-end">
        <x-buttons.submit :title="__('actions.save')" wire:target="save" wire:loading.attr="data-loading" />
    </div>
</form>
