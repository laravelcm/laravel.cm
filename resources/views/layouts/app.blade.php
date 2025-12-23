@props([
    'title' => null,
    'canonical' => null,
])

<x-base-layout :title="$title ?? null" :canonical="$canonical ?? null">
    <div id="main-site" class="flex min-h-screen flex-col justify-between">
        <x-layouts.header />

        <main class="relative z-20 w-full flex-1">
            {{ $slot }}
        </main>

        <x-layouts.footer />
    </div>
</x-base-layout>
