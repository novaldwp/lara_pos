<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use App\Models\Master\Produk;
use App\Models\Main\Stok;
use App\Models\Main\Member;
use App\Models\Main\Setting;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;
use App\Models\Transaction\PenjualanDummy;
use Auth;

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

        return view('transaction.penjualan.index');
    }

    public function getPenjualanCart()
    {
        $pdummy = PenjualanDummy::with(['produk', 'produk.stok'])->orderBy('dummy_id', 'ASC');
        if ($pdummy->count() != 0)
        {
            $pdummy = $pdummy->get();
        }

        $gtotal = $pdummy->sum('dummy_subtotal');

        return view('transaction.penjualan.detail', compact('pdummy', 'gtotal'));
    }

    public function insertPenjualanCart(Request $request)
    {
        $kode   = $request->input('kode');
        $qty    = 1;
        $stok   = Stok::whereHas(
                        'produk', function($q) use($kode) {
                            $q->where('produk_kode', $kode);
                        }
                    )
                    ->where('stok_jumlah', '!=', 0)
                    ->first();

        if ($stok)
        {
            $adummy = PenjualanDummy::where('produk_id', $stok->produk_id);

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
                $pdummy->dummy_harga = $stok->produk->produk_jual;
                $pdummy->dummy_subtotal = $qty * $stok->produk->produk_jual;
                $pdummy->produk_id = $stok->produk->produk_id;
                $pdummy->save();

                return response()->json(['message' => "Successfully added product."], 200);
            }
        }
        else{
            return response()->json(['message' => "Product stock not found."], 404);
        }
    }

    public function plusPenjualanCartQty($id)
    {
        $adummy = PenjualanDummy::where('produk_id', $id);

        if($adummy->count() != 0)
        {
            $adummy = $adummy->first();
            $adummy->dummy_qty = $adummy->dummy_qty + 1;
            $adummy->dummy_subtotal = $adummy->dummy_qty * $adummy->dummy_harga;
            $adummy->save();

            return response()->json(['message' => "Successfully renew qty.", "id" => Auth::user()->id], 200);
        }
    }

    public function minusPenjualanCartQty($id)
    {
        $adummy = PenjualanDummy::where('produk_id', $id);

        if($adummy->count() != 0)
        {
            $adummy = $adummy->first();

            if($adummy->dummy_qty == 1) {
                $adummy->delete();

                $countCart = PenjualanDummy::count();

                return response()->json(['message' => 'Successfully delete item.', 'countCart' => $countCart], 200);
            }
            else {
                $adummy->dummy_qty = $adummy->dummy_qty - 1;
                $adummy->dummy_subtotal = $adummy->dummy_qty * $adummy->dummy_harga;
                $adummy->save();

                return response()->json(['message' => "Successfully renew qty."], 200);
            }
        }
        else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function enterPenjualanCartQty(Request $request, $id){

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

    public function deletePenjualanCartItem($id) {
        $adummy = PenjualanDummy::where('produk_id', $id)->first();

        if ($adummy)
        {
            $adummy->delete();

            $adummy = PenjualanDummy::count();

            return response()->json(['message' => 'Successfully delete item', 'countCart' => $adummy], 200);
        }
        else {
            return response()->json(['message' => 'Error item not found'], 404);
        }

        $selling    = PenjualanDetail::with(['produk'])
                        ->select(DB::raw('count(detailpenjualan_id) as count'))
                        ->groupBy('penjualan_id')
                        ->orderBy('created_at', 'DESC')
                        ->get();

        return response()->json($adummy);
    }

    public function insertPenjualanData(Request $request)
    {
        $id_kasir       = $request->input('cashier_id');
        $member_kode    = $request->input('member_kode');
        $penjualan_kode = $request->input('penjualan_kode');
        $grand_total    = $request->input('grand_total');
        $uang_bayar     = $request->input('uang_bayar');
        $kembalian      = $request->input('kembalian');

        $member       = $this->getMemberByKode($member_kode);

        $penjualan = new Penjualan;
        $penjualan->penjualan_kode      = $penjualan_kode;
        $penjualan->penjualan_total     = $grand_total;
        $penjualan->penjualan_nominal   = $uang_bayar;
        $penjualan->penjualan_kembalian = $kembalian;
        $penjualan->member_id           = ($member != "") ? $member->member_id:"1";
        $penjualan->user_id             = Auth::user()->id;
        $penjualan->save();

        $fetch          = PenjualanDummy::orderBy('dummy_id', 'ASC')->get();
        $penjualan_id   = $penjualan->penjualan_id;

        foreach($fetch as $row) :

            $pdetail = New PenjualanDetail;
            $pdetail->detailpenjualan_qty       = $row->dummy_qty;
            $pdetail->detailpenjualan_harga     = $row->dummy_harga;
            $pdetail->detailpenjualan_subtotal  = $row->dummy_subtotal;
            $pdetail->produk_id                 = $row->produk_id;
            $pdetail->penjualan_id              = $penjualan_id;
            $pdetail->save();

            $fetchstok = Stok::where('produk_id', $row->produk_id)->first();
            $fetchstok->stok_jumlah = $fetchstok->stok_jumlah - $row->dummy_qty;
            $fetchstok->save();

        endforeach;

        $this->clearPenjualanCart();
        $setting = Setting::first();
        $data    = $this->getLastTransactionPenjualan();
        $view = view('transaction.penjualan.print', compact(['setting', 'data']));

        return $view->render();
    }

    public function clearPenjualanCart()
    {
        $delete = PenjualanDummy::truncate();
    }

    public static function getPenjualanCode()
    {

        $year       = date('Y'); // year now
        $month      = date('m'); // month now
        $default    = "0001"; // default value for incrementing
        $key        = "PNJ";
        $count      = DB::table('penjualan')->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        if($count > 0)
        {
            // get last pembelian_kode value
            $value          = DB::table('penjualan')->select('penjualan_kode')->orderBy('penjualan_id', 'DESC')->first();
            $take_numeric   = substr($value->penjualan_kode, 3, 10); //2019110003 from PMB2019110003
            $take_year      = substr($take_numeric, 0, 4); //2019 taking a year string
            $take_month     = substr($take_numeric, 4, 2); //11 taking a month string
            $take_increment = substr($take_numeric, 6, 3); // 003 taking a increment string
            // if looping config
            if($year == $take_year)
            {
                // nested loop if condition 1 is true
                if($month == $take_month)
                {
                    // do the "sum" between $test value and 1
                    $penjualan_kode = $take_numeric + 1;
                }
                else{
                    // if condition 2 fail then generate with same year different month with default value
                    $penjualan_kode = $year.$month.$default;
                }
            }
            else{
                // if condition 1 fail then generate with differet year and month with default value
                $penjualan_kode = $year.$month.$default;
            }
        }
        else{
            $penjualan_kode = $year.$month.$default;
        }

        return response()->json($key.$penjualan_kode);
    }

    public function getMemberByKode($kode)
    {
        $member = Member::where('member_kode', $kode)->first();

        return $member;
    }

    public function getLastTransactionPenjualan()
    {
        $penjualan = Penjualan::with(['penjualan_detail', 'member', 'user', 'penjualan_detail.produk'])
                        ->orderBy('penjualan_id', 'DESC')
                        ->first();

        return $penjualan;
    }
}
