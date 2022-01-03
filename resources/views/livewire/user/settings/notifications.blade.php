<div class="pb-20">
    <div class="flex items-center">
        <div class="flex-1">
            <h3 class="text-lg leading-6 font-medium text-skin-inverted">
                Gérez vos notifications
            </h3>
            <p class="mt-1 max-w-4xl text-sm text-skin-base font-normal">
                Cette page répertorie tous les abonnements à des e-mails pour votre compte.
                Par exemple, vous avez peut-être demandé à être informé par e-mail de la mise à jour d'un thread ou d'un fil de discussion particulier.
            </p>
        </div>
        <div>
            <x-loader wire:loading wire:target="theme" class="text-flag-green ml-3 mr-0"/>
        </div>
    </div>

    <div class="mt-6 sm:mt-5 sm:border-t sm:border-skin-base sm:pt-5">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-5 lg:gap-y-6">
            @forelse($subscriptions as $subscription)
                <div class="p-4 sm:p-5 flex flex-col justify-between rounded-md bg-skin-card-gray">
                    <p class="text-base font-sans leading-6 text-skin-inverted">
                        <a href="{{ route('subscriptions.redirect', [$subscription->subscribeable_id, $subscription->subscribeable_type]) }}" class="text-skin-inverted hover:text-skin-primary-hover font-medium">
                            {{ $subscription->subscribeAble->title }}
                        </a>
                    </p>
                    <div class="mt-3">
                        <button wire:click="unsubscribe('{{ $subscription->uuid }}')" type="button" class="inline-flex items-start px-2.5 py-1.5 text-xs leading-4 font-medium font-sans text-red-600 bg-red-100 hover:bg-red-50 rounded-full">
                            Se désabonner
                        </button>
                    </div>
                </div>
            @empty
                <div class="grid sm:col-span-2 lg:col-span-3 max-w-4xl">
                    <div class="bg-skin-card-gray px-4 py-3 flex rounded-md">
                        <div class="shrink-0">
                            <x-heroicon-o-information-circle class="h-5 w-5 text-blue-500"/>
                        </div>
                        <div class="ml-3 flex-1 text-skin-base font-normal">
                            <span class="font-medium text-blue-500">Astuce:</span> Visitez n'importe quel fil de discussion du forum et cliquez sur le bouton <span class="font-medium text-skin-inverted">"S'abonner"</span> dans la barre latérale.
                            Une fois cliqué, vous recevrez un e-mail chaque fois qu'une réponse sera publiée.
                            Il en va de même pour n'importe quel type de contenu qui offre cette possibilité.
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
