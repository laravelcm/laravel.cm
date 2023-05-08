<x-sticky-content class="space-y-12">
    <div>
        <h4 class="text-lg font-semibold text-skin-inverted font-sans leading-6">{{ __('Top Contributeurs') }}</h4>
        <p class="mt-3 font-normal text-skin-base text-sm">{{ __('Les personnes qui ont lancé le plus de discussions sur le site.') }}</p>
        <div class="mt-6">
            <ul role="list" class="divide-y divide-skin-base">
                @foreach($topContributors as $contributor)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('profile', $contributor->username) }}" class="flex items-center flex-1 min-w-0">
                                <div class="shrink-0">
                                    <x-user.avatar :user="$contributor" class="h-8 w-8" />
                                </div>
                                <div class="ml-3.5 font-sans">
                                    <p class="text-sm font-medium text-skin-inverted truncate">
                                        {{ $contributor->name }}
                                    </p>
                                    <p class="text-sm text-skin-base truncate">
                                        {{ '@' . $contributor->username }}
                                    </p>
                                </div>
                            </a>
                            <div>
                                <span class="inline-flex items-center text-sm leading-5 font-medium text-skin-inverted">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 mr-1 text-skin-muted">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    {{ $contributor->discussions_count }}
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div>
        <h4 class="text-lg font-semibold text-skin-inverted font-sans leading-6">{{ __('Discussions sans commentaires') }}</h4>
        <p class="mt-3 font-normal text-skin-base text-sm">{{ __('Les discussions/sujets qui n’ont pas encore eu de commentaires. Soyez le premier à apporter votre contribution.') }}</p>

        <div class="mt-6">
            <ul role="list" class="divide-y divide-skin-base">
                @foreach($discussions as $discussion)
                    <li class="py-4">
                        <div class="flex space-x-3">
                            <img class="h-6 w-6 object-cover rounded-full" src="{{ $discussion->user->profile_photo_url }}" alt="">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-skin-inverted font-sans">
                                        <a href="{{ route('profile', $discussion->user->username) }}" class="hover:underline">{{ $discussion->user->name }}</a>
                                    </h3>
                                    <p class="text-xs text-skin-muted font-normal truncate">
                                        <time-ago time="{{ $discussion->created_at->getTimestamp() }}" />
                                    </p>
                                </div>
                                <a href="{{ route('discussions.show', $discussion) }}" class="inline-flex text-sm text-skin-base font-normal hover:text-skin-inverted leading-5">
                                    {{ $discussion->title }}
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</x-sticky-content>
