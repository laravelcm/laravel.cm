<div>
    <span class="inline-flex rounded-md shadow-sm">
        @can(App\Policies\DiscussionPolicy::UNSUBSCRIBE, $discussion)
            <x-button type="button" wire:click="unsubscribe" wire:loading.attr="disabled">
                <x-heroicon-s-bell class="h-5 w-5" />
                <span class="mx-2">Se désabonner</span>
                <x-loader class="text-white mx-0" wire:loading wire:target="unsubscribe" />
            </x-button>
        @elsecan(App\Policies\DiscussionPolicy::SUBSCRIBE, $discussion)
            <x-default-button type="button" wire:click="subscribe" wire:loading.attr="disabled">
                <x-heroicon-s-bell class="h-5 w-5" />
                <span class="mx-2">S'abonner</span>
                <x-loader class="text-white mx-0" wire:loading wire:target="subscribe" />
            </x-default-button>
        @endcan
    </span>
</div>
