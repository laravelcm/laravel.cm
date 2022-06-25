<footer class="mx-auto mt-24 w-full max-w-7xl px-4 sm:px-6">
    <div class="border-t border-skin-base py-10">
        <img class="mx-auto h-10 w-auto logo-white" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm">
        <img class="mx-auto h-10 w-auto logo-dark" src="{{ asset('/images/laravelcm-white.svg') }}" alt="Laravel.cm">
        <p class="mt-5 text-center text-sm leading-6 text-skin-muted">
            © 2018 - {{ date('Y') }} Laravel Cameroun. Tous droits réservés.
        </p>
        <div class="mt-10 flex items-center justify-center space-x-4 text-sm font-medium leading-6 text-skin-base">
            <a class="hover:text-skin-inverted-muted hover:underline" href="{{ route('twitter') }}">Twitter</a>
            <div class="h-4 w-px bg-skin-card-gray"></div>
            <a class="hover:text-skin-inverted-muted hover:underline" href="{{ route('github') }}">Github</a>
            <div class="h-4 w-px bg-skin-card-gray"></div>
            <a class="hover:text-skin-inverted-muted hover:underline" href="{{ route('facebook') }}">Facebook</a>
            <div class="h-4 w-px bg-skin-card-gray"></div>
            <a class="hover:text-skin-inverted-muted hover:underline" href="{{ route('linkedin') }}">LinkedIn</a>
            <div class="h-4 w-px bg-skin-card-gray"></div>
            <a class="hover:text-skin-inverted-muted hover:underline" href="{{ route('youtube') }}">YouTube</a>
        </div>
    </div>
</footer>
