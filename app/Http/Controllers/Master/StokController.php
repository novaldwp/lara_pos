<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Stok;
use App\Produk;
use App\PembelianDummy;
use App\PenjualanDummy;
use App\Kategori;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // set session stok
        Session::put('nav_active', 'stok');
        Session::forget('sub_active');

        $stok = Stok::with(['produk'])->orderBy('stok_id', 'DESC')->get();

        if(request()->ajax()) {
            return datatables()->of($stok)
            ->addColumn('action', function($data){
                $button = '
                    <a name="edit" data="'.$data->stok_id.'" id="edit" class="edit btn btn-primary btn-sm">Edit </a>
                ';
                $button .= '
                    &nbsp;&nbsp;
                ';
                $button .= '
                    <a name="delete" data="'.$data->stok_id.'" id="delete" class="delete btn btn-danger btn-sm">Delete </a>
                ';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.stok.index');
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

    public function test()
    {
        // $id = 1;
        // $stok = Produk::with(['stok'])->where('produk_id', $id)->get();
        $pdummy = PenjualanDummy::with(['produk', 'produk.stok'])->orderBy('dummy_id', 'DESC')->get();
        return response()->json(['data' => $pdummy]);
    }
}
