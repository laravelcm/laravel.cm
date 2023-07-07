<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

final class SponsoringController extends Controller
{
    public function sponsors(): View
    {
        $sponsors = Cache::remember(
            key: 'sponsors',
            ttl: 3600,
            callback: fn () => Transaction::with(['user', 'user.media'])
                ->scopes('complete')
                ->get(['id', 'user_id', 'metadata'])
        );

        return view('sponsors.index', [
            'sponsors' => $sponsors
        ]);
    }
}
