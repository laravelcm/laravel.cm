@props(['content'])

<div {{ $attributes }}>
    {!! \App\Markdown\MarkdownHelper::parseLiquidTags(replace_links(Markdown::convertToHtml($content))) !!}
</div>
