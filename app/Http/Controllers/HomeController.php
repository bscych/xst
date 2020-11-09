<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        \Illuminate\Support\Facades\Log::info('HomeController:');
         $user = session('wechat.oauth_user.default');
        return view('home')->with('data', session('school_id').$user);
    }
    
}
