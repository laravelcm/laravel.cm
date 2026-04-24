@props([
    'content' => null,
    'model' => null,
])

<div {{ $attributes }}>
    @if ($model && method_exists($model, 'renderedBody'))
        {!! $model->renderedBody() !!}
    @else
        {!! md_render((string) $content) !!}
    @endif
</div>
