<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use PDF;
use Excel;
use App\Exports\ReportPenjualan;
use App\Models\Master\Produk;
use App\Models\Main\Setting;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $filter     = $request->filter;
        $setting    = Setting::first();
        $penjualan  = $this->getReportPenjualan($filter);

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
        $penjualan['tanggal']   = tanggal_indonesia($penjualan->created_at);

        return response()->json($penjualan);
    }

    public function exportToPdf(Request $request)
    {
        $filter     = $request->filter;
        $penjualan  = $this->convertDataToHTML($filter);

        $pdf        = \App::make('dompdf.wrapper');
        $pdf->loadHTML($penjualan);

        return $pdf->setPaper('a4', 'landscape')->stream(time().uniqid().'.pdf');
    }

    public function getReportPenjualan($filter)
    {
        $day        = date('d');
        $month      = date('m');
        $year       = date('Y');
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
                        ->orderBy('penjualan_id', 'DESC')
                        ->get();

        return $penjualan;
    }

    public function convertDataToHTML($filter)
    {
        $data   = $this->getReportPenjualan($filter);

        $html   = '
            <h3 align="center">Laporan Transaksi Penjualan</h3>
            <br><br>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="background-color:seagreen;">
                    <th width="5%" style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">No. Transaksi</th>
                    <th style="border: 1px solid;">Pembeli</th>
                    <th style="border: 1px solid;">Quantity</th>
                    <th style="border: 1px solid;">Tanggal</th>
                    <th style="border: 1px solid;">Petugas</th>
                    <th style="border: 1px solid;">Subtotal</th>
                </tr>
            ';

        $i = 1;
        foreach($data as $row)
        {
            $html .= '
                <tr style="text-align:center;">
                    <td style="border: 1px solid;">'.$i.'</td>
                    <td style="border: 1px solid;">'.$row->penjualan_kode.'</td>
                    <td style="border: 1px solid;">'.$row->member->member_nama.'</td>
                    <td style="border: 1px solid;">'.$row->penjualan_detail[0]->total.'</td>
                    <td style="border: 1px solid;">'.date('d-m-Y', strtotime($row->created_at)).'</td>
                    <td style="border: 1px solid;">'.$row->user->name.'</td>
                    <td style="border: 1px solid;">'.$row->penjualan_total.'</td>
                </tr>
            ';
            $i++;
        }

        $html .= '</table>';

        return $html;
    }
}
