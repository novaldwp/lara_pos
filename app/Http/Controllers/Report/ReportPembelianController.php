<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction\Pembelian;
use App\Models\Transaction\PembelianDetail;
use App\Models\Master\Supplier;
use App\Models\Master\Produk;
use App\Models\Main\Setting;
use DB;

class ReportPembelianController extends Controller
{
    public function index(Request $request)
    {
        $filter     = $request->filter;
        $day        = date('d');
        $month      = date('m');
        $year       = date('Y');

        $setting    =   Setting::first();
        $pembelian  =   Pembelian::with([
                            'pembelian_detail' => function ($q)
                                {
                                    $q->select(DB::raw('sum(detailpembelian_jumlah) as total, detailpembelian_id, pembelian_id, produk_id'));
                                    $q->groupBy('pembelian_id');
                                },
                            'supplier',
                            'user'
                        ])
                        ->when($filter == "day", function ($q) use ($day)
                            {
                                $q->whereDay('created_at', $day);
                            }
                        )
                        ->when($filter == "month", function ($q) use ($month)
                            {
                                $q->whereMonth('created_at', $month);
                            }
                        )
                        ->when($filter == "year", function ($q) use ($year)
                            {
                                $q->whereYear('created_at', $year);
                            }
                        )
                        ->orderBy('pembelian_id', 'DESC')
                        ->get();

        if(request()->ajax()) {
            return datatables()->of($pembelian)
            ->addColumn('action', function($data){
                $button = '
                    <a name="report-detail" data="'.$data->pembelian_id.'" id="report-detail" class="report-detail btn btn-primary btn-sm">Detail </a>
                ';
                return $button;
            })
            ->addColumn('tanggal', function($data) {
                $tanggal = date('d-m-Y', strtotime($data->created_at));

                return $tanggal;
            })
            ->addColumn('pembelian_total', function($data) {
                $pembelian_total = convert_to_rupiah($data->pembelian_total);

                return $pembelian_total;
            })
            ->rawColumns(['action', 'tanggal', 'pembelian_total'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('report.pembelian.index', compact(['setting']));
    }

    public function show($id)
    {
        $pembelian = Pembelian::with([
                            'supplier',
                            'pembelian_detail' => function($q) {
                                $q->with('produk');
                            },
                            'user'
                        ])
                        ->where('pembelian_id', $id)
                        ->first();
        $pembelian['tanggal']   = tanggal_indonesia($pembelian->created_at);

        return response()->json($pembelian);
    }
}
