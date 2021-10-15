<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\UpdateProfileRequest;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        dd($request->all());
    }
}
