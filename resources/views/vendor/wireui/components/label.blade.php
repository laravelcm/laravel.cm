<label {{ $attributes->class([
        'block text-sm font-medium',
        'text-negative-600'  =>  $hasError,
        'text-skin-inverted-muted' => !$hasError,
    ]) }}>
    {{ $label ?? $slot }}
</label>
