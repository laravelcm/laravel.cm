<div class="pb-20">
    <div class="flex items-center">
        <div class="flex-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Gérez vos notifications</h3>
            <p class="mt-1 max-w-4xl text-sm font-normal text-gray-500 dark:text-gray-400">
                Cette page répertorie tous les abonnements à des e-mails pour votre compte. Par exemple, vous avez
                peut-être demandé à être informé par e-mail de la mise à jour d'un thread ou d'un fil de discussion
                particulier.
            </p>
        </div>
        <div>
            <x-loader wire:loading wire:target="theme" class="ml-3 mr-0 text-flag-green" />
        </div>
    </div>

    <div class="mt-6 sm:mt-5 sm:border-t sm:border-skin-base sm:pt-5">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 lg:gap-x-5 lg:gap-y-6">
            @forelse ($subscriptions as $subscription)
                <div class="flex flex-col justify-between rounded-md bg-skin-card-gray p-4 sm:p-5">
                    <p class="font-sans text-base leading-6 text-gray-900">
                        <a
                            href="{{ route('subscriptions.redirect', [$subscription->subscribeable_id, $subscription->subscribeable_type]) }}"
                            class="font-medium text-gray-900 hover:text-primary-600-hover"
                        >
                            {{ $subscription->subscribeAble->title }}
                        </a>
                    </p>
                    <div class="mt-3">
                        <button
                            wire:click="unsubscribe('{{ $subscription->uuid }}')"
                            type="button"
                            class="inline-flex items-start rounded-full bg-red-100 px-2.5 py-1.5 font-sans text-xs font-medium leading-4 text-red-600 hover:bg-red-50"
                        >
                            Se désabonner
                        </button>
                    </div>
                </div>
            @empty
                <div class="grid max-w-4xl sm:col-span-2 lg:col-span-3">
                    <div class="flex rounded-md bg-skin-card-gray px-4 py-3">
                        <div class="shrink-0">
                            <x-heroicon-o-information-circle class="size-5 text-blue-500" />
                        </div>
                        <div class="ml-3 flex-1 font-normal text-gray-500 dark:text-gray-400">
                            <span class="font-medium text-blue-500">Astuce:</span>
                            Visitez n'importe quel fil de discussion du forum et cliquez sur le bouton
                            <span class="font-medium text-gray-900">"S'abonner"</span>
                            dans la barre latérale. Une fois cliqué, vous recevrez un e-mail chaque fois qu'une réponse
                            sera publiée. Il en va de même pour n'importe quel type de contenu qui offre cette
                            possibilité.
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
