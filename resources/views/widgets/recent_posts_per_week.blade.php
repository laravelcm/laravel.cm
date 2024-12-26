<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="flex items-center justify-between p-4">
        <h4 class="text-lg font-medium text-gray-900">Articles de la semaine</h4>
        <span
            class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800"
        >
            {{ $articles->count() }}
        </span>
    </div>
    <div class="flex items-center justify-between bg-skin-body px-4 py-3">
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Article</span>
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Auteur</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @forelse ($articles as $article)
            <li class="flex items-center justify-between px-4 py-2.5">
                <a
                    href="{{ route('articles.show', $article) }}"
                    class="flex-1 truncate text-sm leading-4 text-gray-500 dark:text-gray-400 hover:text-gray-900"
                >
                    {{ $article->title }}
                </a>
                <a
                    href="{{ route('profile', $article->author->username) }}"
                    class="text-sm leading-5 text-gray-400 dark:text-gray-500 hover:text-flag-green hover:underline"
                >
                    {{ '@' . $article->author->username }}
                </a>
            </li>
        @empty
            <li class="flex flex-col items-center justify-center px-4 py-5">
                <x-heroicon-o-newspaper class="size-10 text-gray-700 dark:text-gray-300" />
                <span class="mt-2 text-sm leading-5 text-gray-500 dark:text-gray-400">Aucun article n'a été publié cette semaine.</span>
            </li>
        @endforelse
    </ul>
</div>
