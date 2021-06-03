<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-skin-base']) }}>
    {{ $slot->isNotEmpty() ? $slot : $fallback }}
</label>
