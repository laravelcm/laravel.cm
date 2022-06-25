<div>
    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="relative bg-skin-card py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-users class="h-5 w-5 text-green-600" />
                    <p class="ml-3 text-sm font-medium text-skin-base truncate">{{ __('Utilisateurs') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-skin-inverted">{{ $users['count'] }}</p>
                @if($users['increase'])
                    <x-increased class="ml-2" :value="$users['current']" />
                @else
                    <x-decreased class="ml-2" :value="$users['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-skin-base">vs mois dernier</span>
            </dd>
        </div>

        <div class="relative bg-skin-card py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-newspaper class="h-5 w-5 text-green-600" />
                    <p class="ml-3 text-sm font-medium text-skin-base truncate">{{ __('Articles') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-skin-inverted">{{ $articles['count'] }}</p>
                @if($articles['increase'])
                    <x-increased class="ml-2" :value="$articles['current']" />
                @else
                    <x-decreased class="ml-2" :value="$articles['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-skin-base">vs mois dernier</span>
            </dd>
        </div>

        <div class="relative bg-skin-card py-5 px-4 sm:py-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="flex items-center">
                    <x-heroicon-o-eye class="h-5 w-5 text-green-600" />
                    <p class="ml-3 text-sm font-medium text-skin-base truncate">{{ __('Vues sur les articles') }}</p>
                </div>
            </dt>
            <dd class="mt-2 flex items-baseline">
                <p class="text-2xl font-semibold text-skin-inverted">{{ $views['count'] }}</p>
                @if($views['increase'])
                    <x-increased class="ml-2" :value="$views['current']" />
                @else
                    <x-decreased class="ml-2" :value="$views['current']" />
                @endif
                <span class="ml-2 text-sm leading-4 text-skin-base">vs mois dernier</span>
            </dd>
        </div>
    </dl>
</div>
