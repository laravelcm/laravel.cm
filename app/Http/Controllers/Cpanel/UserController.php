<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function __invoke()
    {
        return view('cpanel.users.index', [
            'users' => User::verifiedUsers()->latest()->paginate(15),
        ]);
    }
}
