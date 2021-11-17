<div class="sticky space-y-16 top-4">
    <div>
        <h4 class="text-lg font-semibold text-skin-inverted font-sans leading-6">Top Contributeurs</h4>
        <p class="mt-3 font-normal text-skin-base text-sm">Les personnes qui ont lancé le plus de discussions sur le site.</p>
        <div class="mt-6">
            <ul role="list" class="divide-y divide-skin-base">
                @foreach($topContributors as $contributor)
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8 rounded-full" src="{{ $contributor->profile_photo_url }}" alt="">
                            </div>
                            <div class="flex-1 min-w-0 font-sans">
                                <p class="text-sm font-medium text-skin-inverted truncate">
                                    {{ $contributor->name }}
                                </p>
                                <p class="text-sm text-skin-base truncate">
                                    {{ '@' . $contributor->username }}
                                </p>
                            </div>
                            <div>
                                <span class="inline-flex items-center text-sm leading-5 font-medium text-skin-inverted">
                                    <x-heroicon-s-chat-alt-2 class="h-5 w-5 mr-1 text-skin-muted" /> {{ $contributor->discussions_count }}
                                </span>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div>
        <h4 class="text-lg font-semibold text-skin-inverted font-sans leading-6">Discussions sans commentaires</h4>
        <p class="mt-3 font-normal text-skin-base text-sm">Les discussions/sujets qui n’ont pas encore eu de commentaires. Soyez le premier à apporter votre avis.</p>

        <div class="mt-6">
            <ul role="list" class="divide-y divide-skin-base">
                @foreach($discussions as $discussion)
                    <li class="py-4">
                        <div class="flex space-x-3">
                            <img class="h-6 w-6 rounded-full" src="{{ $discussion->author->profile_photo_url }}" alt="">
                            <div class="flex-1 space-y-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-medium text-skin-inverted font-sans">{{ $discussion->author->name }}</h3>
                                    <p class="text-xs text-skin-muted font-normal truncate">{{ $discussion->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-sm text-skin-base font-normal">{{ $discussion->title }}</p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>
