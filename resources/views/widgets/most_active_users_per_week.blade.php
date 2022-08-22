<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="p-4 flex items-center justify-between">
        <h4 class="text-lg font-medium text-skin-inverted">Utilisateurs actifs</h4>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $users->count() }}</span>
    </div>
    <div class="bg-skin-body px-4 py-3 flex items-center justify-between">
        <span class="text-xs leading-4 uppercase tracking-wider text-skin-inverted-muted">Utilisateur</span>
        <span class="text-xs leading-4 uppercase tracking-wider text-skin-inverted-muted">Profil</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @forelse($users as $user)
            <li class="flex items-center justify-between px-4 py-2.5">
                <span class="flex-1 text-sm leading-4 truncate text-skin-base">
                    {{ $user->name }} <span class="text-green-500 italic">({{ '@'.$user->username }})</span>
                </span>
                <a href="{{ route('profile', $user->username) }}" class="text-sm leading-5 text-skin-muted hover:text-flag-green hover:underline">Afficher</a>
            </li>
        @empty
            <li class="flex flex-col items-center justify-center px-4 py-5">
                <x-heroicon-o-trending-up class="w-10 h-10 text-skin-inverted-muted" />
                <span class="mt-2 text-sm leading-5 text-skin-base">Aucune activité disponible pour cette semaine.</span>
            </li>
        @endforelse
    </ul>
</div>
