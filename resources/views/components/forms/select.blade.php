@props([
    'items' => false,
    'key' => 'id',
    'value' => 'name'
])

<select {!! $attributes->merge(['class' => 'block w-full py-2 px-3 border border-skin-input bg-skin-input placeholder-skin-input focus:placeholder-skin-input-focus font-normal text-skin-base rounded-md shadow-sm focus:outline-none focus:border-flag-green focus:ring focus:ring-flag-green focus:ring-opacity-50 sm:text-sm']) !!}>
    @if($items)
        @foreach($items as $item)
            <option value="{{ $item->{$key} }}">{{ $item->{$value} }}</option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>
