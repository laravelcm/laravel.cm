<div>
    <form wire:submit="updateProfil">
        {{ $this->form }}

        <x-buttons.submit :title="__('actions.save')" class="mt-10" />
    </form>
</div>
