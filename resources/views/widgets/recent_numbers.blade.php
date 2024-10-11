<div>
    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="relative overflow-hidden rounded-lg bg-skin-card px-4 py-5 shadow sm:px-6 sm:py-6">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-users class="size-5 text-green-600" />
                    <p class="ml-3 truncate text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Utilisateurs') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $users['count'] }}</p>
                @if ($users['increase'])
                    <x-increased class="ml-2" :value="$users['current']" />
                @else
                    <x-decreased class="ml-2" :value="$users['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-gray-500 dark:text-gray-400">vs mois dernier</span>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-skin-card px-4 py-5 shadow sm:px-6 sm:py-6">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-newspaper class="size-5 text-green-600" />
                    <p class="ml-3 truncate text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Articles') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $articles['count'] }}</p>
                @if ($articles['increase'])
                    <x-increased class="ml-2" :value="$articles['current']" />
                @else
                    <x-decreased class="ml-2" :value="$articles['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-gray-500 dark:text-gray-400">vs mois dernier</span>
            </dd>
        </div>

        <div class="relative overflow-hidden rounded-lg bg-skin-card px-4 py-5 shadow sm:px-6 sm:py-6">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-eye class="size-5 text-green-600" />
                    <p class="ml-3 truncate text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Vues sur les articles') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ $views['count'] }}</p>
                @if ($views['increase'])
                    <x-increased class="ml-2" :value="$views['current']" />
                @else
                    <x-decreased class="ml-2" :value="$views['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-gray-500 dark:text-gray-400">vs mois dernier</span>
            </dd>
        </div>
    </dl>
</div>
