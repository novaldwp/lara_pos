<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Penjualan;
use App\Member;
use App\Produk;

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

        // $day        = date('d');
        // $transaksi  = Penjualan::whereDay('created_at', $day);
        // // j = jumlah
        // $jtransaksi = $transaksi->count();
        // $jmember    = Member::count();
        // $jproduk    = Produk::count();
        // $jpenjualan = $transaksi->sum('penjualan_total');

        // $member    = Member::orderBy('created_at', 'DESC')->take(4)->get();
        // $produk    = Produk::orderBy('created_at', 'DESC')->take(4)->get();

        // return view('dashboard', compact('jtransaksi', 'jmember', 'jproduk', 'jpenjualan', 'produk', 'member'));
        return view('dashboard');
    }
}
