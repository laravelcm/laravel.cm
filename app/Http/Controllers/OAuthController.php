<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use App\Traits\HasSocialite;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Contracts\User as SocialUser;

final class OAuthController extends Controller
{
    use HasSocialite;

    public function redirectToProvider(string $provider): RedirectResponse | \Symfony\Component\HttpFoundation\RedirectResponse
    {
        if ( ! in_array($provider, $this->getAcceptedProviders(), true)) {
            return redirect()
                ->route('login')
                ->withErrors(__('La connexion via :provider n\'est pas disponible', ['provider' => e($provider)]));
        }

        return $this->getAuthorizationFirst($provider);
    }

    public function handleProviderCallback(string $provider): RedirectResponse
    {
        try {
            $socialiteUser = $this->getSocialiteUser($provider);
        } catch (InvalidStateException $exception) {
            session()->flash('error', __('La demande a expirée. Veuillez réessayer.'));

            return redirect()->route('login');
        }

        try {
            $user = User::findOrCreateSocialUserProvider($socialiteUser, $provider);
        } catch (ModelNotFoundException $exception) {
            // @phpstan-ignore-next-line
            return $this->userNotFound($socialiteUser->getRaw(), $exception->getMessage());
        }

        $this->updateOrRegisterProvider($user, $socialiteUser, $provider);

        return $this->userFound($user);
    }

    private function userFound(User $user): RedirectResponse
    {
        Auth::login($user);

        return redirect('/dashboard');
    }

    private function userNotFound(User $socialUser, string $errorMessage): RedirectResponse
    {
        session(['socialData' => $socialUser->toArray()]);

        return redirect()->route('register')->withErrors($errorMessage);
    }

    private function updateOrRegisterProvider(User $user, SocialUser $socialiteUser, string $provider): void
    {
        if ( ! $user->hasProvider($provider)) {
            $user->providers()->save(new SocialAccount([
                'provider' => $provider,
                'provider_id' => $socialiteUser->id,
                'token' => $socialiteUser->token,
                'avatar' => $socialiteUser->avatar,
            ]));
        }

        $user->providers()->update([
            'token' => $socialiteUser->token,
            'avatar' => $socialiteUser->avatar,
        ]);
    }
}
