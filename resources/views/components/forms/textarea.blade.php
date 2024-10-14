@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block p-2.5 w-full text-sm placeholder-gray-500 bg-gray-50 rounded-lg border border-gray-200  focus:ring-primary-500 focus:border-primary-500']) !!}>{{ $slot }}</textarea>
