<div {{ $attributes }}>
    {!! \App\Markdown\MarkdownHelper::parseLiquidTags($toHtml($slot)) !!}
</div>
