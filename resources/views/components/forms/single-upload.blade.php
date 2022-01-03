@props([
    'preview' => false,
    'file' => false,
    'error' => false,
])

<div x-data="{ focused: false }" class="relative w-full h-56 overflow-hidden">
    @if($preview && ! $file)
        <div class="relative shrink-0 rounded-md overflow-hidden">
            <img class="h-56 w-full object-cover rounded-md" src="{{ $preview }}" alt="" />
            <div class="absolute top-0 right-0 z-20 flex justify-center w-5 h-5 mt-2 mr-2 text-sm leading-tight text-white bg-gray-700 rounded-full opacity-25 cursor-pointer hover:opacity-50" wire:click="$set('preview', '')">×</div>
        </div>
    @endif

    @if($file)
        <div class="relative shrink-0 rounded-md overflow-hidden">
            <img class="h-56 w-full object-cover rounded-md" src="{{ $file->temporaryUrl() }}" alt="" />
            <div class="absolute top-0 right-0 z-20 flex justify-center w-5 h-5 mt-2 mr-2 text-sm leading-tight text-white bg-gray-700 rounded-full opacity-25 cursor-pointer hover:opacity-50" wire:click="$set('file', '')">×</div>
        </div>
    @else
        <label for="{{ $attributes['id'] }}" class="group flex items-center justify-center h-full border-2 border-skin-input border-dashed rounded-md cursor-pointer overflow-hidden">
            <div class="text-center" wire:loading.remove wire:target="file">
                <svg class="mx-auto h-12 w-12 text-skin-muted" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="mt-1 text-sm text-skin-base">
                    <span class="font-medium text-green-500 focus:outline-none focus:underline transition duration-150 ease-in-out">
                        {{ __('Upload a file') }}
                    </span>
                    {{ __('or drag and drop') }}
                </p>
                <p class="mt-1 text-xs text-skin-muted">
                    {{ __('PNG, JPG, GIF up to 1MB') }}
                </p>
                <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" {{ $attributes }} />
            </div>
            <div class="w-full h-full hidden flex items-center justify-center" wire:loading.class.remove="hidden" wire:target="file">
                <x-loader wire:loading wire:target="file" class="text-green-600" />
            </div>
        </label>
    @endif
    @if($error)
        <p class="mt-2 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
