<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SponsoringController extends Controller
{
    public function sponsors(): View
    {
        return view('sponsors.index');
    }
}
