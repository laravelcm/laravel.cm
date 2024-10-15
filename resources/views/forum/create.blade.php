<x-app-layout title="Créer un nouveau sujet">
    <div class="mx-auto max-w-4xl py-12">
        <div class="space-y-8 divide-y divide-skin-base sm:space-y-5">
            <div>
                <h3 class="font-heading text-lg font-medium leading-6 text-gray-900">Créer un sujet</h3>
                <p class="mt-1 max-w-2xl text-sm font-normal text-gray-500 dark:text-gray-400">
                    Assurez-vous d'avoir lu nos
                    <a href="{{ route('rules') }}" class="font-medium text-primary-600 hover:text-primary-600-hover">
                        règles de conduite
                    </a>
                    avant de continuer.
                </p>
            </div>

            <livewire:forum.create-thread />
        </div>
    </div>
</x-app-layout>
