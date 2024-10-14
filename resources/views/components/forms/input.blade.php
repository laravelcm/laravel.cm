@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex w-full py-2 rounded-lg placeholder-gray-500 border-gray-200 focus:ring-primary-500 focus:ring-2 focus:border-transparent focus:outline-none sm:text-sm']) !!}>
