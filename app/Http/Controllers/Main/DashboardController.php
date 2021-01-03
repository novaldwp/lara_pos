<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use DB;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;
use App\Models\Main\Member;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $countProduk        = Produk::count();
        $countSupplier      = Supplier::count();
        $countPenjualan     = Penjualan::whereDate('created_at', date('Y-m-d'))->count();
        $sumPenjualan       = Penjualan::whereDate('created_at', date('Y-m-d'))->sum('penjualan_total');
        $topProduk          = PenjualanDetail::with(['produk'])
                                ->select(DB::raw('sum(detailpenjualan_qty) as total, produk_id'))
                                ->groupBy('produk_id')
                                ->orderBy('total', 'DESC')
                                ->where('produk_id', '!=', '')
                                ->take(5)
                                ->get();
        $recentPenjualan    = Penjualan::with(['penjualan_detail' => function ($q)
                                    {
                                        $q->select(DB::raw('sum(detailpenjualan_qty) as total, detailpenjualan_id, penjualan_id'));
                                        $q->groupBy('penjualan_id');
                                    },
                                    'member'
                                ])
                                ->whereDate('created_at', date('Y-m-d'))
                                ->orderBy('penjualan_id', 'DESC')
                                ->take(5)
                                ->get();

        return view('main.dashboard.index',
                        compact('countPenjualan', 'countProduk', 'countSupplier',
                                'sumPenjualan', 'topProduk', 'recentPenjualan')
                    );
    }
}
