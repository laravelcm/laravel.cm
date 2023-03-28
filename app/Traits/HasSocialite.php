<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

trait HasSocialite
{
    public function getAcceptedProviders(): array
    {
        return ['github', 'twitter'];
    }

    protected function getSocialiteUser(string $provider): User
    {
        return Socialite::driver($provider)->user();
    }

    protected function getAuthorizationFirst($provider): RedirectResponse
    {
        $socialite = Socialite::driver($provider);
        $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");
        $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
        $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");

        if ($scopes) {
            $socialite->scopes($scopes);
        }

        if ($with) {
            $socialite->with($with);
        }

        if ($fields) {
            $socialite->fields($fields);
        }

        return $socialite->redirect();
    }
}
