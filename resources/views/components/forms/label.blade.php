@props(['value', 'required'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
    @if(isset($required))
        <span class="text-red-600">*</span>
    @endif
</label>
