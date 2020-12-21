<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Produk;
use App\Stok;
use App\Penjualan;
use App\PenjualanDetail;
use App\PenjualanDummy;

class PenjualanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $pdummy = PenjualanDummy::with(['produk', 'produk.stok'])->orderBy('dummy_id', 'ASC');
        if ($pdummy->count() != 0)
        {
            $pdummy = $pdummy->get();
        }

        $gtotal = $pdummy->sum('dummy_subtotal');

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
        $adummy = PenjualanDummy::where('produk_id', $id);

        if($adummy->count() != 0)
        {
            $adummy = $adummy->first();
            $adummy->dummy_qty = $adummy->dummy_qty + 1;
            $adummy->dummy_subtotal = $adummy->dummy_qty * $adummy->dummy_harga;
            $adummy->save();

            return response()->json(['message' => "Successfully renew qty."], 200);
        }

    }

    public function minus_penjualan_cart($id)
    {
        $adummy = PenjualanDummy::where('produk_id', $id);

        if($adummy->count() != 0)
        {
            $adummy = $adummy->first();
            $adummy->dummy_qty = $adummy->dummy_qty - 1;
            $adummy->dummy_subtotal = $adummy->dummy_qty * $adummy->dummy_harga;
            $adummy->save();

            return response()->json(['message' => "Successfully renew qty."], 200);
        }

    }

    public function enter_penjualan_cart(Request $request, $id){

        $qty    = $request->input('qty');
        $adummy = PenjualanDummy::where('produk_id', $id);

        if($adummy->count() != 0)
        {
            $adummy = $adummy->first();
            $adummy->dummy_qty = $qty;
            $adummy->dummy_subtotal = $adummy->dummy_qty * $adummy->dummy_harga;
            $adummy->save();

            return response()->json(['message' => 'Successfully renew qty.'], 200);
        }
    }

    public function insert_penjualan_data(Request $request)
    {
        $id_kasir     = $request->input('cashier_id');
        $id_member    = $request->input('id_member');
        $no_penjualan = $request->input('no_penjualan');
        $grand_total  = $request->input('grand_total');
        $uang_bayar   = $request->input('uang_bayar');
        $kembalian    = $request->input('kembalian');

        $penjualan = new Penjualan;
        $penjualan->penjualan_kode      = $no_penjualan;
        $penjualan->penjualan_total     = $grand_total;
        $penjualan->penjualan_nominal   = $uang_bayar;
        $penjualan->penjualan_kembalian = $kembalian;
        $penjualan->member_id           = $id_member;
        $penjualan->cashier_id          = $id_kasir;
        $penjualan->save();


        $fetch          = PenjualanDummy::orderBy('dummy_id', 'ASC')->get();
        $penjualan_id   = $penjualan->penjualan_id;

        foreach($fetch as $row) :

            $pdetail = New PenjualanDetail;
            $pdetail->detail_qty        = $row->dummy_qty;
            $pdetail->detail_harga      = $row->dummy_harga;
            $pdetail->detail_subtotal   = $row->dummy_subtotal;
            $pdetail->produk_id         = $row->produk_id;
            $pdetail->penjualan_id      = $penjualan_id;
            $pdetail->save();

            $fetchstok = Stok::where('produk_id', $row->produk_id)->first();
            $fetchstok->stok_jumlah = $fetchstok->stok_jumlah - $row->dummy_qty;
            $fetchstok->save();

        endforeach;

        $this->clear_penjualan_cart();

        return response()->json(['data' => 'Insert data successfully.']);

    }

    public function clear_penjualan_cart()
    {
        $delete = PenjualanDummy::truncate();

    }






}
