<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Produk;
use App\Stok;
use App\PenjualanDummy;

class PenjualanController extends Controller
{

    public function index()
    {
        Session::put('nav_active', 'transaksi');
        Session::put('sub_active', 'penjualan');

        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_penjualan_cart()
    {
        $pdummy = PenjualanDummy::with(['produk'])->orderBy('dummy_id', 'ASC')->get();
        $gtotal = $pdummy->sum('dummy_subtotal');

        // return response()->json([$pdummy]);
        return view('penjualan.detail', compact('pdummy', 'gtotal'));
    }

    public function insert_penjualan_cart(Request $request)
    {
        $kode = $request->input('kode');
        $qty  = 1;
        $produk = Produk::with(['stok'])->where('produk_kode', $kode);

        if ($produk->count() != 0)
        {
            $produk = $produk->first();
            $adummy = PenjualanDummy::where('produk_id', $produk->produk_id);

            if ($adummy->count() != 0)
            {
                $adummy = $adummy->first();
                $adummy->dummy_qty = $adummy->dummy_qty + $qty;
                $adummy->dummy_subtotal = $adummy->dummy_harga * $adummy->dummy_qty;
                $adummy->save();

                return response()->json(['message' => "Successfully renew qty."], 200);
            }
            else{

                $pdummy = new PenjualanDummy;
                $pdummy->dummy_qty = $qty;
                $pdummy->dummy_harga = $produk->produk_jual;
                $pdummy->dummy_subtotal = $qty * $produk->produk_jual;
                $pdummy->produk_id = $produk->produk_id;
                $pdummy->save();

                return response()->json(['message' => "Successfully added product."], 200);
            }
        }
        else{

            return response()->json(['message' => "Product not found."], 501);
        }

    }

    public function plus_penjualan_cart($id)
    {

    }

    public function minus_penjualan_cart($id)
    {

    }

}
