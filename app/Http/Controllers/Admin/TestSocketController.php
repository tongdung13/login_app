<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestSocketController extends Controller
{
    public function index ()
    {
        return view('admin.socket.index');
    }

    public function postSocket()
    {
        event(new MessageEvent());
        return response()->json('success');
    }
}
