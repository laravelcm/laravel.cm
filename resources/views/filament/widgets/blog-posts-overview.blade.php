<x-filament::widget>
    <div>
        <div class="border-b border-gray-200 pb-5">
            <h3 class="text-xl font-medium leading-6 text-slate-700">{{ __('Derniers articles') }}</h3>
        </div>
        <div class="mt-4 grid gap-5 sm:grid-cols-3 sm:gap-6">
            @foreach ($latestArticles as $article)
{{--                <x-admin.recent-post :article="$article" />--}}
            @endforeach
        </div>
    </div>
</x-filament::widget>
