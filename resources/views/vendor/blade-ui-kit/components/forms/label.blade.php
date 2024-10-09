<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-5 text-gray-500 dark:text-gray-400']) }}>
    {{ $slot->isNotEmpty() ? $slot : $fallback }}
</label>
