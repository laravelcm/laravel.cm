<div>
    <div class="rounded-lg bg-skin-card-gray px-4 py-5 sm:p-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Notifications</h3>
        <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500 dark:text-gray-400">
            @can(App\Policies\ThreadPolicy::UNSUBSCRIBE, $thread)
                <p>Vous recevez actuellement des notifications de mises à jour de ce sujet.</p>
            @elsecan(App\Policies\ThreadPolicy::SUBSCRIBE, $thread)
                <p>Vous ne recevez pas de notifications de ce sujet.</p>
            @endcan
        </div>
        <div class="mt-5">
            <span class="inline-flex rounded-md shadow-sm">
                @can(App\Policies\ThreadPolicy::UNSUBSCRIBE, $thread)
                    <x-button type="button" wire:click="unsubscribe" wire:loading.attr="disabled">
                        <x-heroicon-s-bell class="size-5" />
                        <span class="mx-2">Se désabonner</span>
                        <x-loader class="mx-0 text-white" wire:loading wire:target="unsubscribe" />
                    </x-button>
                @elsecan(App\Policies\ThreadPolicy::SUBSCRIBE, $thread)
                    <x-default-button type="button" wire:click="subscribe" wire:loading.attr="disabled">
                        <x-heroicon-s-bell class="size-5" />
                        <span class="mx-2">S'abonner</span>
                        <x-loader class="mx-0 text-white" wire:loading wire:target="subscribe" />
                    </x-default-button>
                @endcan
            </span>
        </div>
    </div>
</div>
