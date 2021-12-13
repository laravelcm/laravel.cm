@props(['link' => null])

@if($link)
    <a href="{{ $link }}" {{ $attributes->merge(['class' => 'button inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500']) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => 'button inline-flex items-center justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500']) }}>
        {{ $slot }}
    </button>
@endif
