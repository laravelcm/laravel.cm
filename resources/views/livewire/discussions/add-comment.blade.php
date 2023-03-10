<div class="relative flex space-x-3">
    @auth
        <div class="flex-shrink-0">
            <div class="relative">
                <img
                    class="h-10 w-10 rounded-full object-cover bg-skin-card-gray flex items-center justify-center ring-8 ring-body"
                    src="{{ $authenticate->profile_photo_url }}"
                    alt="{{ $authenticate->name }}"
                />
                <span class="absolute -bottom-0.5 -right-1 bg-skin-body rounded-tl px-0.5 py-px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-skin-muted">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </span>
            </div>
        </div>
    @endauth

    <div @class([
        'min-w-0 flex-1',
        'filter blur-sm' => ! $authenticate,
    ])>
        <label for="body" class="sr-only">{{ __('Commentaire') }}</label>
        <x-textarea
            wire:model.defer="body"
            name="body"
            id="body"
            placeholder="{{ __('Laisser un commentaire, vous pouvez utilise du **Markdown**') }}"
            rows="4"
            :disabled="$authenticate === null"
        />
        <div class="mt-4 sm:flex sm:items-center sm:justify-between sm:space-x-4">
            @if($isRoot)
                <p class="text-sm text-skin-base max-w-xl font-normal">
                    {{ __('Veuillez vous assurer d\'avoir lu nos') }} <a href="{{ route('rules') }}" class="font-medium text-skin-primary hover:text-skin-primary-hover">{{ __('règles de conduite') }}</a> {{ __('avant de répondre à ce fil de conversation.') }}
                </p>
            @endif
            <div class="mt-3 flex items-center justify-end space-x-3 sm:mt-0">
                @if($isReply)
                    <x-default-button type="reset" wire:click="cancel">{{ __('Annuler') }}</x-default-button>
                @endif
                <x-button type="button" class="inline-flex" wire:click="saveComment">
                    <x-loader class="text-white" wire:loading wire:target="saveComment" />
                    {{ __('Commenter') }}
                </x-button>
            </div>
        </div>
    </div>
    @guest
        <div class="absolute inset-0 flex items-center justify-center bg-skin-card bg-opacity-10 py-8">
            <p class="text-center font-sans text-skin-base">
                {{ __('Veuillez vous') }} <a href="{{ route('login') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">{{ __('connecter') }}</a> {{ __('ou') }}
                <a href="{{ route('register') }}" class="text-skin-primary hover:text-skin-primary-hover hover:underline">{{ __('créer un compte') }}</a> {{ __('pour participer à cette conversation') }}.
            </p>
        </div>
    @endguest
</div>
