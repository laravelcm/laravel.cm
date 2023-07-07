<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\EnterpriseResource;
use App\Http\Resources\EnterpriseResourceCollection;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PublicController extends Controller
{
    public function featured(): AnonymousResourceCollection
    {
        $enterprises = Enterprise::query()
            ->scopes('featured')
            ->limit(6)
            ->get();

        return EnterpriseResource::collection($enterprises);
    }

    public function paginate(Request $request): EnterpriseResourceCollection
    {
        $filters = $request->query();

        $enterprises = Enterprise::query()
            ->filters($request)
            ->latest()
            ->paginate((int) $request->query('per_page', '12'));

        return new EnterpriseResourceCollection($enterprises, $filters);
    }
}
