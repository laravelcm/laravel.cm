<div x-data @scrollToComment.window="window.scrollTo({ top: 0, behavior: 'smooth' })">
    <livewire:discussions.add-comment :is-root="true" :discussion="$discussion" />
    @if($this->comments->isNotEmpty())
        <div class="mt-10">
            <ul role="list" class="space-y-4">
                @foreach($this->comments as $comment)
                    <livewire:discussions.comment :comment="$comment" :key="$comment->id" />
                @endforeach
            </ul>
        </div>
    @endif
</div>
