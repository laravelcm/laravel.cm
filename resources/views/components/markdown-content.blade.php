@props(['content'])

<div {{ $attributes }}>
    {!! \App\Markdown\MarkdownHelper::parseLiquidTags(Markdown::convertToHtml($content)) !!}
</div>
