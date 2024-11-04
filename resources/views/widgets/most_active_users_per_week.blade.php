<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="flex items-center justify-between p-4">
        <h4 class="text-lg font-medium text-gray-900">Utilisateurs actifs</h4>
        <span
            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"
        >
            {{ $users->count() }}
        </span>
    </div>
    <div class="items-center heroicon-o flex justify-between bg-skin-body px-4 py-3">
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Utilisateur</span>
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Profil</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @forelse ($users as $user)
            <li class="flex items-center justify-between px-4 py-2.5">
                <span class="flex-1 truncate text-sm leading-4 text-gray-500 dark:text-gray-400">
                    {{ $user->name }}
                    <span class="italic text-green-500">({{ '@' . $user->username }})</span>
                </span>
                <a
                    href="{{ route('profile', $user->username) }}"
                    class="text-sm leading-5 text-skin-muted hover:text-flag-green hover:underline"
                >
                    Afficher
                </a>
            </li>
        @empty
            <li class="flex flex-col items-center justify-center px-4 py-5">
                <x-untitledui-bar-chart class="size-10 text-gray-700 dark:text-gray-300" />
                <span class="mt-2 text-sm leading-5 text-gray-500 dark:text-gray-400">
                    Aucune activité disponible pour cette semaine.
                </span>
            </li>
        @endforelse
    </ul>
</div>
