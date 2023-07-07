<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Enterprise\RegisterRequest;
use App\Http\Resources\EnterpriseResource;
use App\Models\Enterprise;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        /** @var User $owner */
        $owner = $request->user();

        if ($owner->hasEnterprise()) {
            return response()->json([
                'error' => 'Ce compte possède déjà une entreprise associée.',
            ]);
        }

        $enterprise = Enterprise::query()->create([
            'name' => $request->input('name'),
            'slug' => $request->input('name'),
            'website' => $request->input('website'),
            'user_id' => $request->input('user_id'),
            'is_public' => false,
        ]);

        return response()->json([
            'message' => 'Votre entreprise a été cree avec succès',
            'enterprise' => new EnterpriseResource($enterprise),
        ]);
    }
}
