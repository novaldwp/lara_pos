<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;

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
        Session::put('nav_active', 'dashboard');
        Session::forget('sub_active');

        if(Auth::user()->level == 1) {
            return view('admin.index');
        }
        else{
            return view('kasir.index');
        }
    }
}
