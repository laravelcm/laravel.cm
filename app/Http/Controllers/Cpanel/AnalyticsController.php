<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

final class AnalyticsController extends Controller
{
    public function __invoke(): View
    {
        return view('cpanel.analytics');
    }
}
