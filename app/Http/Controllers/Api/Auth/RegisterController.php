<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\ApiRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\AuthenticateUserResource;
use App\Models\SocialAccount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()->create([
            'name' => $request->input('name'),
            'username' => $request->input('name'),
            'email' => strtolower($request->input('email')),
            'password' => Hash::make($request->input('password')),
        ]);

        $user->assignRole('company');

        //TODO: Send new company registration notification on Slack
        event(new ApiRegistered($user));

        return response()->json(
            array_merge(
                ['message' => 'Votre compte a été créé avec succès. Un e-mail de vérification vous a été envoyé.'],
                $this->userMetaData($user)
            )
        );
    }

    public function googleAuthenticator(Request $request): JsonResponse
    {
        $socialUser = $request->input('socialUser');

        $user = User::query()->where('email', $socialUser['email'])->first();

        if (! $user) {
            /** @var User $user */
            $user = User::query()->create([
                'name' => $socialUser['name'],
                'email' => $socialUser['email'],
                'username' => $socialUser['id'],
                'email_verified_at' => now(),
                'avatar_type' => strtolower($socialUser['provider']),
            ]);

            $user->assignRole('company');
        }

        if ($user->hasRole('user')) {
            return response()->json(['error' => 'Vous n\'êtes pas autorisé à accéder à cette section avec cette adresse e-mail.'], 401);
        }

        if (! $user->hasProvider($socialUser['provider'])) {
            $user->providers()->save(new SocialAccount([
                'provider' => $socialUser['provider'],
                'provider_id' => $socialUser['id'],
                'token' => $socialUser['idToken'],
                'avatar' => $socialUser['photoUrl'],
            ]));
        }

        $user->providers()->update([
            'token' => $socialUser['idToken'],
            'avatar' => $socialUser['photoUrl'],
        ]);

        //TODO: Send welcome email to user 1 hour after registration

        //TODO: Send new company registration notification on Slack

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();

        return response()->json($this->userMetaData($user));
    }

    private function userMetaData(User $user): array
    {
        return [
            'user' => new AuthenticateUserResource($user),
            'token' => $user->createToken($user->email)->plainTextToken,
            'roles' => $user->roles()->pluck('name'),
            'permissions' => $user->permissions()->pluck('name'),
        ];
    }
}
