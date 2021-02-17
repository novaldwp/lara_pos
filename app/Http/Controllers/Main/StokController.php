<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Models\Main\Stok;

class StokController extends Controller
{
    public function index()
    {
        $stok = Stok::with(['produk'])
                    ->whereNotNull('produk_id')
                    ->orderBy('stok_id', 'DESC')
                    ->get();

        if(request()->ajax()) {
            return datatables()->of($stok)
            ->addIndexColumn()
            ->make(true);
        }

        return view('main.stok.index');
    }

    public function test()
    {
        // $id = 1;
        // $stok = Produk::with(['stok'])->where('produk_id', $id)->get();
        $pdummy = PenjualanDummy::with(['produk', 'produk.stok'])->orderBy('dummy_id', 'DESC')->get();
        return response()->json(['data' => $pdummy]);
    }
}
