<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="p-4">
        <h4 class="text-lg font-medium text-skin-inverted">Articles les plus visités</h4>
    </div>
    <div class="flex items-center justify-between bg-skin-body px-4 py-3">
        <span class="text-xs uppercase leading-4 tracking-wider text-skin-inverted-muted">Article</span>
        <span class="text-xs uppercase leading-4 tracking-wider text-skin-inverted-muted">Vues</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @foreach ($articles as $article)
            <li class="flex items-center justify-between px-4 py-2.5">
                <a
                    href="{{ route('articles.show', $article) }}"
                    class="flex-1 truncate text-sm leading-4 text-skin-base hover:text-skin-inverted"
                >
                    {{ $article->title }}
                </a>
                <span class="text-sm leading-5 text-skin-muted">{{ $article->views_count }}</span>
            </li>
        @endforeach
    </ul>
</div>
