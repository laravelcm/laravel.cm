@php($ads = Illuminate\Support\Arr::random(config('lcm.ads')))

<div id="laravelcm-ads">
    <a href="{{ $ads['url'] }}" class="block">
        <img class="rounded-lg" src="{{ asset("/images/ads/{$ads['image']}.png") }}" alt="{{ $ads['alt'] }}" width="457" height="336">
    </a>
    <p class="mt-4 font-normal">
        <a href="{{ $ads['url'] }}" class="text-sm leading-5 text-skin-base">
            {{ $ads['description'] }}
        </a>
    </p>
    <div class="mt-2">
        <a href="{{ $ads['url'] }}" class="text-sm text-skin-primary hover:text-skin-primary-hover font-medium hover:underline">En savoir plus →</a>
    </div>
</div>
