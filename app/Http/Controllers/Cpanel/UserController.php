<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;

final class UserController extends Controller
{
    public function __invoke(): View
    {
        return view('cpanel.users.index', [
            'users' => User::verifiedUsers()->latest()->paginate(15),
        ]);
    }
}
