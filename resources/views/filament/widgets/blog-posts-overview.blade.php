<x-filament::widget>
    <div>
        <div class="pb-5 border-b border-gray-200">
            <h3 class="text-xl leading-6 font-medium text-slate-700">{{ __('Derniers articles') }}</h3>
        </div>
        <div class="mt-4 grid gap-5 sm:grid-cols-3 sm:gap-6">
            @foreach($latestArticles as $article)
                <x-admin.recent-post :article="$article" />
            @endforeach
        </div>
    </div>
</x-filament::widget>
