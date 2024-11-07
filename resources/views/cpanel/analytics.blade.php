<x-app-layout title="Statistiques">
    <x-container class="mx-auto max-w-7xl px-4 sm:px-6">
        <div class="divide-y divide-skin-base">
            <div class="pb-10">
                <div>
                    <h3 class="font-heading text-3xl font-semibold leading-8 text-gray-900">
                        Rapport Hebdomadaires
                    </h3>
                    <p class="mt-2 max-w-4xl text-lg leading-6 text-gray-500 dark:text-gray-400">
                        Toutes les informations pour le rapport hebdomadaire pour la semaine (
                        <span class="font-medium capitalize text-green-500">
                            {{ __(':start - :end', ['start' => now()->startOfWeek()->isoFormat('DD MMMM'),'end' => now()->endOfWeek()->isoFormat('DD MMMM'),]) }}
                        </span>
                        )
                    </p>
                </div>
                <div class="mt-8 grid grid-cols-3 gap-x-8 gap-y-10">
                    @widget('recentPostsPerWeek')
                    @widget('mostViewedPostsPerWeek')
                    @widget('mostLikedPostsPerWeek')
                    @widget('mostActiveUsersPerWeek')
                </div>
            </div>
            <div class="py-10"></div>
        </div>
    </x-container>
</x-app-layout>
