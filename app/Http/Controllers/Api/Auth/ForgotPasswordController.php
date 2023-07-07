<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;

final class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request): JsonResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return Password::RESET_LINK_SENT === $status
                    ? response()->json(['message' => __('L\'e-mail de réinitialisation du mot de passe a été envoyé avec succès !')])
                    : response()->json(['error' => __('Un courriel ne pourrait être envoyé à cette adresse électronique !')], 401);
    }
}
