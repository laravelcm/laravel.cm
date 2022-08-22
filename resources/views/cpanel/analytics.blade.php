<x-layouts.cp title="Statistiques">
    <x-container class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="divide-y divide-skin-base">
            <div class="pb-10">
                <div>
                    <h3 class="text-3xl leading-8 font-semibold text-skin-inverted font-heading">Rapport Hebdomadaires</h3>
                    <p class="mt-2 text-lg leading-6 max-w-4xl text-skin-base">
                        Toutes les informations pour le rapport hebdomadaire pour la semaine
                        (<span class=" font-medium text-green-500 capitalize">{{ __(':start - :end', ['start' => now()->startOfWeek()->isoFormat('DD MMMM'), 'end' => now()->endOfWeek()->isoFormat('DD MMMM')]) }}</span>)
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
</x-layouts.cp>
