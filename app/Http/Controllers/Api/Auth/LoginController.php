<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Traits\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    use UserResponse;

    public function login(LoginRequest $request): JsonResponse
    {
        $email = $request->string('email')->lower()->toString();

        /** @var User|null $user */
        $user = User::query()
            ->with(['roles', 'permissions'])
            ->where('email', $email)
            ->first();

        if (! $user instanceof User || ! Auth::attempt(['email' => $email, 'password' => $request->input('password')])) {
            throw ValidationException::withMessages([
                'email' => __("Les informations d'identification fournies sont incorrectes."),
            ]);
        }

        if (! $user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => __("Votre adresse email n'a pas été vérifiée."),
            ]);
        }

        if ($user->banned()) {
            throw ValidationException::withMessages([
                'email' => __('Votre compte est suspendu.'),
            ]);
        }

        $user->tokens()->delete();

        $user->forceFill([
            'last_login_at' => Date::now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        return response()->json($this->userMetaData($user));
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $token = $user->currentAccessToken();

        if ($token !== null && method_exists($token, 'delete')) {
            $token->delete();
        }

        return response()->json(['message' => __('Déconnecté avec succès')]);
    }
}
