<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Pembelian;
use App\Supplier;
use App\Produk;
use App\Stok;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::put('nav_active', 'transaksi');
        Session::put('sub_active', 'pembelian');

        $supplier   = Supplier::orderBy('supplier_id', 'ASC')->get();
        $produk     = Produk::orderBy('produk_id', 'ASC')->get();

        if(request()->ajax()) {
            return datatables()->of($produk)
            ->addColumn('action', function($data){
                $button = '
                    <a name="select" data="'.$data->produk_id.'" id="select" class="select btn btn-primary btn-sm">Pilih </a>
                ';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.pembelian.index', compact('supplier', 'produk'));
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

    public function get_pembelian_kode()
    {

        $pembelian = Pembelian::get_pembelian_kode();

        return response()->json($pembelian);
    }

    public function get_by_id($id)
    {
        $produk = Produk::with(['stok'])->where('produk_id', $id)->get();

        return response()->json($produk);
    }

    public function storeDummy(Request $request)
    {

    }

}
