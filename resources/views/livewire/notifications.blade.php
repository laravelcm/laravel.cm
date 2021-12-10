<div>
    @forelse ($notifications as $date => $record)
        <div class="pb-10">
            <div>
                <h2 id="notification-date-{{ Str::slug($date) }}" class="inline-flex items-center bg-skin-primary bg-opacity-20 px-2.5 py-1.5 rounded-full text-sm inline-flex gap-x-3 font-medium text-skin-primary font-sans">
                    <x-heroicon-o-calendar class="h-5 w-5"/>
                    {{ $date }}
                </h2>
            </div>

            <div class="mt-4 flow-root">
                <ul role="list" class="-mb-2">
                    @foreach($record as $notification)
                        @includeIf("components.notifications.{$notification->data['type']}")
                    @endforeach
                </ul>
            </div>
        </div>
    @empty
        <div class="max-w-lg mx-auto flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
            <div class="text-center max-w-sm mx-auto">
                <x-heroicon-o-bell class="h-10 w-10 text-skin-primary mx-auto" />
                <p class="mt-1 text-skin-base text-sm leading-5">Vous n'avez pas de notifications non lues.</p>
            </div>
        </div>

        <div class="mt-10 max-w-lg mx-auto">
            <h2 class="text-lg font-medium text-skin-inverted font-sans">Lancer un nouveau contenu ?</h2>
            <p class="mt-1 text-sm text-skin-base font-normal">Commencer par choisir quel type de contenu vous voulez créer.</p>
            <ul role="list" class="mt-6 border-t border-b border-skin-base divide-y divide-skin-base">
                <li>
                    <div class="relative group py-4 flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-flag-green">
                                <x-heroicon-o-rss class="h-6 w-6 text-white"/>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-skin-inverted font-sans">
                                <a href="{{ route('articles.new') }}">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Rédiger un article
                                </a>
                            </div>
                            <p class="text-sm text-skin-base font-normal">Partager un tutoriel ou une information importante.</p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                        </div>
                    </div>
                </li>

                <li>
                    <div class="relative group py-4 flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-flag-red">
                                <x-heroicon-o-chat-alt class="h-6 w-6 text-white"/>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-skin-inverted font-sans">
                                <a href="{{ route('discussions.new') }}">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Démarrer une discussion
                                </a>
                            </div>
                            <p class="text-sm text-skin-base font-normal">Vous souhaitez apporter une pierre à l'édifice.</p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                        </div>
                    </div>
                </li>

                <li>
                    <div class="relative group py-4 flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-yellow-500">
                                <x-heroicon-s-question-mark-circle class="h-6 w-6 text-white"/>
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-skin-inverted">
                                <a href="{{ route('forum.new') }}">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    Demander de l'aide
                                </a>
                            </div>
                            <p class="text-sm text-skin-base font-normal">Vous avez un problème? Trouvons ensemble une solution.</p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <x-heroicon-s-chevron-right class="h-5 w-5 text-skin-muted group-hover:text-skin-base" />
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    @endforelse
</div>
