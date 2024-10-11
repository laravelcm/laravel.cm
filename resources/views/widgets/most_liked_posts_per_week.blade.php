<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="p-4">
        <h4 class="text-lg font-medium text-gray-900">Articles les plus likés</h4>
    </div>
    <div class="flex items-center justify-between bg-skin-body px-4 py-3">
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Article</span>
        <span class="text-xs uppercase leading-4 tracking-wider text-gray-700 dark:text-gray-300">Likes</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @foreach ($articles as $article)
            <li class="flex items-center justify-between px-4 py-2.5">
                <a
                    href="{{ route('articles.show', $article) }}"
                    class="flex-1 truncate text-sm leading-4 text-gray-500 dark:text-gray-400 hover:text-gray-900"
                >
                    {{ $article->title }}
                </a>
                <span class="text-sm leading-5 text-skin-muted">{{ $article->reactions_count }}</span>
            </li>
        @endforeach
    </ul>
</div>
