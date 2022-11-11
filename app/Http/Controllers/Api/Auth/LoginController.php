<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\AuthenticateUserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = User::query()
            ->with(['roles', 'permissions'])
            ->where('email', strtolower($request->input('email')))
            ->first();

        $sanitized = [
            'email' => strtolower($request->input('email')),
            'password' => $request->input('password'),
        ];

        if (empty($user) || !Auth::attempt($sanitized)) {
            throw ValidationException::withMessages([
                'email' => 'Les informations d\'identification fournies sont incorrectes.',
            ]);
        }

        if (! empty($user->tokens())) {
            $user->tokens()->delete();
        }

        $user->last_login_at = Carbon::now();
        $user->last_login_ip = $request->ip();
        $user->save();

        return response()->json([
            'user' => new AuthenticateUserResource($user),
            'token' => $user->createToken($request->input('email'))->plainTextToken,
            'roles' => $user->roles()->pluck('name'),
            'permissions' => $user->permissions()->pluck('name'),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Déconnecté avec succès']);
    }
}
