<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-skin-base font-normal']) }}>
    {{ $slot->isNotEmpty() ? $slot : $fallback }}
</label>
