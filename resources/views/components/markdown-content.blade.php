@props(['content'])

<div {{ $attributes }}>
    {!! replace_links(\App\Markdown\MarkdownHelper::parseLiquidTags(Markdown::convert($content))) !!}
</div>
