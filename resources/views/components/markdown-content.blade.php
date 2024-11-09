@props([
    'content',
])

<div {{ $attributes }}>
    {!! replace_links(\App\Markdown\MarkdownHelper::parseLiquidTags(\GrahamCampbell\Markdown\Facades\Markdown::convert($content))) !!}
</div>
