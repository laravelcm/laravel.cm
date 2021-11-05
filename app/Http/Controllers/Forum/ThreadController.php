<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        return view('forum.index');
    }

    public function channel(Channel $channel)
    {
        return view('forum.index');
    }
}
