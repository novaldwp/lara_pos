<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Pembelian;
use App\PembelianDetail;
use App\PembelianDummy;
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
        $pembelian_kode = $request->input('pembelian_kode');
        $supplier_id    = $request->input('supplier_id');

        $fetch = PembelianDummy::orderBy('pembeliandummy_id', 'ASC')->get();

        $pembelian                  = new Pembelian;
        $pembelian->pembelian_kode  = $pembelian_kode;
        $pembelian->supplier_id     = $supplier_id;
        $pembelian->save();

        $pembelian_id = $pembelian->pembelian_id;

        foreach($fetch as $row) :
            $pmbdetail = new PembelianDetail;
            $pmbdetail->pembelian_id                = $pembelian_id;
            $pmbdetail->produk_id                   = $row->produk_id;
            $pmbdetail->detailpembelian_jumlah      = $row->pembelian_jumlah;
            $pmbdetail->detailpembelian_subtotal    = $row->subtotal;

            $count = Stok::where('produk_id', $row->produk_id)->count();

            if($count > 0)
            {
                $stok               = Stok::where('produk_id', $row->produk_id)->firstOrFail();
                $stok->stok_jumlah  = $stok->stok_jumlah + $row->pembelian_jumlah;
                $stok->save();
            }
            else{
                $stok = new Stok;
                $stok->produk_id    = $row->produk_id;
                $stok->stok_jumlah  = $row->pembelian_jumlah;
                $stok->save();
            }

            $pmbdetail->save();

        endforeach;

        $this->deleteDummy();

        return response()->json([ $success = 'Pembelian berhasil!' ]);
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

    public function get_pembelian_detail()
    {
        $pdummy = PembelianDummy::with(['produk'])->orderBy('pembeliandummy_id', 'DESC')->get();
        $gtotal = $pdummy->sum('subtotal');
        return view('admin.pembelian.detail', compact('pdummy', 'gtotal'));
    }

    public function get_produk_by_kode($kode)
    {
        $produk = Produk::with(['stok'])->where('produk_kode', $kode)->first();

        return response()->json($produk);
    }
    public function storeDummy(Request $request)
    {
        $produk_id          = $request->input('produk_id');
        $pembelian_jumlah   = $request->input('pembelian_jumlah');
        $produk_beli        = $request->input('produk_beli');
        $subtotal           = $pembelian_jumlah * $produk_beli;

        $count = PembelianDummy::where('produk_id', $produk_id)->count();
        if ($count > 0 )
        {
            $fdummy = PembelianDummy::where('produk_id', $produk_id)->firstOrFail();
            $fdummy->pembelian_jumlah = $fdummy->pembelian_jumlah + $pembelian_jumlah;
            $fdummy->save();
        }
        else{

            $pdummy                     = new PembelianDummy;
            $pdummy->produk_id          = $produk_id;
            $pdummy->pembelian_jumlah   = $pembelian_jumlah;
            $pdummy->produk_beli        = $produk_beli;
            $pdummy->subtotal           = $subtotal;
            $pdummy->save();

        }
        return response()->json("suksesssss");
    }

    public function deleteDummy()
    {
        $delete = PembelianDummy::truncate();

    }
}
