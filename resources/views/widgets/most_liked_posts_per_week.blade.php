<div class="overflow-hidden rounded-md bg-skin-card">
    <div class="p-4">
        <h4 class="text-lg font-medium text-skin-inverted">Articles les plus likés</h4>
    </div>
    <div class="bg-skin-body px-4 py-3 flex items-center justify-between">
        <span class="text-xs leading-4 uppercase tracking-wider text-skin-inverted-muted">Article</span>
        <span class="text-xs leading-4 uppercase tracking-wider text-skin-inverted-muted">Likes</span>
    </div>
    <ul role="list" class="divide-y divide-skin-input">
        @foreach($articles as $article)
            <li class="flex items-center justify-between px-4 py-2.5">
                <a href="{{ route('articles.show', $article) }}" class="flex-1 text-sm leading-4 truncate text-skin-base hover:text-skin-inverted">{{ $article->title }}</a>
                <span class="text-sm leading-5 text-skin-muted">{{ $article->reactions_count }}</span>
            </li>
        @endforeach
    </ul>
</div>
