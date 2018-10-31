<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $message = $request->session()->pull('status', '');
        return view('index', ['message' => $message]);
    }
}
