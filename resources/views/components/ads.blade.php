@php($ads = Illuminate\Support\Arr::random(config('lcm.ads')))

<div id="laravelcm-ads">
    <a href="{{ $ads['url'] }}" class="block">
        <img
            class="rounded-lg"
            src="{{ asset("/images/ads/{$ads['image']}.png") }}"
            alt="{{ $ads['alt'] }}"
            width="457"
            height="336"
        />
    </a>
    <p class="mt-4 font-normal">
        <a href="{{ $ads['url'] }}" class="text-sm leading-5 text-gray-500 dark:text-gray-400">
            {{ $ads['description'] }}
        </a>
    </p>
    <div class="mt-2">
        <a
            href="{{ $ads['url'] }}"
            class="text-sm font-medium text-primary-600 hover:text-primary-600-hover hover:underline"
        >
            En savoir plus →
        </a>
    </div>
</div>
