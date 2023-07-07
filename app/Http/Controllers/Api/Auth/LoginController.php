<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Traits\UserResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    use UserResponse;

    public function login(LoginRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->with(['roles', 'permissions'])
            ->where('email', mb_strtolower($request->input('email')))
            ->first();

        $sanitized = [
            'email' => mb_strtolower($request->input('email')),
            'password' => $request->input('password'),
        ];

        if ( ! $user || ! Auth::attempt($sanitized)) {
            throw ValidationException::withMessages([
                'email' => __('Les informations d\'identification fournies sont incorrectes.'),
            ]);
        }

        if ( ! $user->tokens()) {
            $user->tokens()->delete();
        }

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();

        return response()->json($this->userMetaData($user));
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json(['message' => __('Déconnecté avec succès')]);
    }
}
