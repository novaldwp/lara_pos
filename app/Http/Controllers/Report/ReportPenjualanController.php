<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Master\Produk;
use App\Models\Main\Setting;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $filter     = $request->filter;
        $day        = date('d');
        $month      = date('m');
        $year       = date('Y');

        $setting    = Setting::first();
        $penjualan  = Penjualan::with([
                            'penjualan_detail' => function ($q)
                                {
                                    $q->select(DB::raw('sum(detailpenjualan_qty) as total, detailpenjualan_id, penjualan_id, produk_id'));
                                    $q->groupBy('penjualan_id');
                                },
                            'member',
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
                        // ->select(DB::raw('sum(penjualan_total) as penjualan_total, penjualan_kode, created_at, penjualan_id'))
                        ->orderBy('penjualan_id', 'DESC')
                        ->get();

        if(request()->ajax()) {
            return datatables()->of($penjualan)
            ->addColumn('action', function($data){
                $button = '
                    <a name="report-detail" data="'.$data->penjualan_id.'" id="report-detail" class="report-detail btn btn-primary btn-sm">Detail </a>
                ';
                return $button;
            })
            ->addColumn('tanggal', function($data) {
                $tanggal = date('d-m-Y', strtotime($data->created_at));

                return $tanggal;
            })
            ->addColumn('penjualan_total', function($data) {
                $penjualan_total = convert_to_rupiah($data->penjualan_total);

                return $penjualan_total;
            })
            ->rawColumns(['action', 'tanggal', 'penjualan_total'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('report.penjualan.index', compact(['setting']));
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['member', 'penjualan_detail' => function($q) {
                            $q->with('produk');
                        }, 'user'])->where('penjualan_id', $id)->first();
        // $penjualan  = Penjualan::with(['penjualan_detail'])->where('penjualan_id', $id)->first();
        // $penjualan['tanggal']   = tanggal_indonesia($penjualan->created_at);

        return response()->json($penjualan);
    }
}
