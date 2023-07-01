<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

trait HasSocialite
{
    /**
     * @return string[]
     */
    public function getAcceptedProviders(): array
    {
        return ['github'];
    }

    protected function getSocialiteUser(string $provider): User
    {
        return Socialite::driver($provider)->user();
    }

    protected function getAuthorizationFirst(string $provider): RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        $socialite = Socialite::driver($provider);
        $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");
        $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
        $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");

        if ($scopes) {
            $socialite->scopes($scopes); // @phpstan-ignore-line
        }

        if ($with) {
            $socialite->with($with); // @phpstan-ignore-line
        }

        if ($fields) {
            $socialite->fields($fields); // @phpstan-ignore-line
        }

        return $socialite->redirect();
    }
}
