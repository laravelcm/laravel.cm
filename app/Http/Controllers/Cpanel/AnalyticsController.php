<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;

class AnalyticsController extends Controller
{
    public function __invoke()
    {
        return view('cpanel.analytics');
    }
}
