@php($ads = Illuminate\Support\Arr::random(config('lcm.ads')))

<div id="laravelcd-ads">
    <a href="{{ $ads['url'] }}" target="_blank" class="block aspect-[2/1] rounded-lg overflow-hidden ring-1 ring-gray-200/50 shadow dark:ring-white/20">
        <img
            class="size-full object-cover"
            src="{{ asset("/images/ads/{$ads['image']}.png") }}"
            alt="{{ $ads['alt'] }}"
        />
    </a>
    <p class="mt-4 text-sm text-gray-500 dark:text-gray-300">
        {{ __($ads['description']) }}
    </p>
    <div class="mt-2">
        <a
            href="{{ $ads['url'] }}"
            target="_blank"
            class="text-sm font-medium text-primary-600 hover:text-primary-600-hover hover:underline"
        >
            {{ __('global.view_more') }}
        </a>
    </div>
</div>
