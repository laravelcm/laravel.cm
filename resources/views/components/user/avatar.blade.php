@props(['user', 'span' => '-right-1 top-0 ring-2 h-4 w-4', 'container' => ''])

@if($user->is_sponsor)
    <span class="relative inline-block {{ $container }}">
        <img {{ $attributes->merge(['class' => 'object-cover rounded-full ring-2 !ring-yellow-500']) }} src="{{ $user->profile_photo_url }}" alt="{{ $user->username() }}">
        <span class="absolute {{ $span }} flex items-center justify-center rounded-full bg-white p-1 ring-yellow-500">
            <svg class="w-full h-full text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
            </svg>
        </span>
    </span>
@else
    <img {{ $attributes->merge(['class' => 'object-cover rounded-full ']) }} src="{{ $user->profile_photo_url }}" alt="{{ $user->username() }}">
@endif
