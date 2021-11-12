<div>
    @if($articles->isNotEmpty())
        <div>
            <div class="space-y-8 sm:space-y-10 max-w-lg mx-auto lg:max-w-none">
                @foreach ($articles as $article)
                    <x-articles.overview :article="$article" />
                @endforeach
            </div>
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
            <div class="text-center max-w-sm mx-auto">
                <x-heroicon-o-newspaper class="h-10 w-10 text-skin-primary mx-auto" />
                <p class="mt-1 text-skin-base text-sm leading-5">{{ $user->name }} n'a pas encore posté d'articles</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('articles.new')" class="mt-4">
                        <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                        Nouvel Article
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
