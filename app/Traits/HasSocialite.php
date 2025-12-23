<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

/**
 * @phpstan-ignore trait.unused
 */
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
        $scopes = config(sprintf('services.%s.scopes', $provider), false);
        $with = config(sprintf('services.%s.with', $provider), false);
        $fields = config(sprintf('services.%s.fields', $provider), false);

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
