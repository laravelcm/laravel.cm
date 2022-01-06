<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function home()
    {
        return view('cpanel.dashboard');
    }
}
