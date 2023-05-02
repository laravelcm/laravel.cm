@props(['user', 'articles'])

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
                <svg class="h-10 w-10 text-skin-primary mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
                <p class="mt-1 text-skin-base text-sm leading-5">{{ __(':name  n\'a pas encore posté d\'articles', ['name' => $user->name]) }}</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('articles.new')" class="mt-4">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('Nouvel Article') }}
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
