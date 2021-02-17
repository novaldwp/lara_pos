<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Session;
use Auth;
use App\Models\Transaction\Pembelian;
use App\Models\Transaction\PembelianDetail;
use App\Models\Transaction\PembelianDummy;
use App\Models\Master\Supplier;
use App\Models\Master\Produk;
use App\Models\Main\Stok;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier   = Supplier::orderBy('supplier_nama', 'ASC')->get();
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

        return view('transaction.pembelian.index', compact('supplier', 'produk'));
    }

    public function store(Request $request)
    {
        $pembelian_kode = $request->input('pembelian_kode');
        $supplier_id    = $request->input('supplier_id');

        $fetch = PembelianDummy::orderBy('pembeliandummy_id', 'ASC')->get();

        $pembelian                  = new Pembelian;
        $pembelian->pembelian_kode  = $pembelian_kode;
        $pembelian->supplier_id     = $supplier_id;
        $pembelian->pembelian_total = $fetch->sum('subtotal');
        $pembelian->supplier_id     = $supplier_id;
        $pembelian->user_id         = Auth::user()->id;
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

        return response()->json(['message' => 'Pembelian produk berhasil.']);
    }

    public static function getPembelianCode()
    {

        $year       = date('Y'); // year now
        $month      = date('m'); // month now
        $default    = "0001"; // default value for incrementing
        $key        = "PMB";
        $count      = DB::table('pembelian')->whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        if($count > 0)
        {
            // get last pembelian_kode value
            $value          = DB::table('pembelian')->select('pembelian_kode')->orderBy('pembelian_id', 'DESC')->first();
            $take_numeric   = substr($value->pembelian_kode, 3, 10); //2019110003 from PMB2019110003
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
                    $pembelian_kode = $take_numeric + 1;
                }
                else{
                    // if condition 2 fail then generate with same year different month with default value
                    $pembelian_kode = $year.$month.$default;
                }
            }
            else{
                // if condition 1 fail then generate with differet year and month with default value
                $pembelian_kode = $year.$month.$default;
            }
        }
        else{
            $pembelian_kode = $year.$month.$default;
        }

        return response()->json($key.$pembelian_kode);
    }

    public function getPembelianDetail()
    {
        $pdummy = PembelianDummy::with(['produk'])->orderBy('pembeliandummy_id', 'DESC')->get();
        $gtotal = $pdummy->sum('subtotal');

        return view('transaction.pembelian.detail', compact('pdummy', 'gtotal'));
    }

    public function get_produk_by_kode($kode)
    {
        $produk = Produk::with(['stok'])->where('produk_kode', $kode)->first();

        return response()->json($produk);
    }

    public function insertPembelianCart(Request $request)
    {
        $produk_id          = $request->input('produk_id');
        $pembelian_jumlah   = $request->input('pembelian_jumlah');
        $produk_beli        = $request->input('produk_beli');
        $subtotal           = $pembelian_jumlah * $produk_beli;

        $fdummy = PembelianDummy::where('produk_id', $produk_id);

        if ($fdummy->count() != 0 )
        {
            $fdummy                     = $fdummy->first();
            $fdummy->pembelian_jumlah   = $fdummy->pembelian_jumlah + $pembelian_jumlah;
            $fdummy->subtotal           = $fdummy->subtotal + ($pembelian_jumlah * $produk_beli);

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

    public function enterPembelianCartQty(Request $request, $id)
    {
        $qty    = $request->input('qty');
        $pdummy = PembelianDummy::where('produk_id', $id);

        if ($pdummy->count() != 0)
        {
            $pdummy = $pdummy->first();
            $pdummy->pembelian_jumlah = $qty;
            $pdummy->subtotal   = $pdummy->produk_beli * $qty;
            $pdummy->save();

            return response()->json(['message' => 'Successfully renew qty.'], 200);
        }
    }

    public function deletePembelianCartItem($id)
    {
        $pdummy = PembelianDummy::where('produk_id', $id)->first();

        if ($pdummy)
        {
            $pdummy->delete();
            $count  = PembelianDummy::count();

            return response()->json(['message' => 'Produk berhasil dihapus.', 'count' => $count], 200);
        }
        else {
            return response()->json(['message' => 'Produk tidak ditemukan.'], 404);
        }
    }

    public function deleteDummy()
    {
        $delete = PembelianDummy::truncate();
    }
}
