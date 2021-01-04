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

        $setting    = Setting::first();
        $pembelian  = $this->getReportPembelian($filter);

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

    public function exportToPdf(Request $request)
    {
        $filter     = $request->filter;
        $pembelian  = $this->convertDataToHTML($filter);

        $pdf        = \App::make('dompdf.wrapper');
        $pdf->loadHTML($pembelian);

        return $pdf->setPaper('a4', 'landscape')->stream('pembelian-'.time().'.pdf');
    }

    public function convertDataToHTML($filter)
    {
        $data  = $this->getReportPembelian($filter);

        $html   = '
            <h3 align="center">Laporan Transaksi Pembelian</h3>
            <br><br>
            <table width="100%" style="border-collapse: collapse; border: 0px;">
                <tr style="background-color:seagreen;">
                    <th width="5%" style="border: 1px solid;">No</th>
                    <th style="border: 1px solid;">No. Transaksi</th>
                    <th style="border: 1px solid;">Supplier</th>
                    <th style="border: 1px solid;">Quantity</th>
                    <th style="border: 1px solid;">Subtotal</th>
                    <th style="border: 1px solid;">Petugas</th>
                    <th style="border: 1px solid;">Tanggal</th>
                </tr>
            ';

        $i = 1;
        foreach($data as $row)
        {
            $html .= '
                <tr style="text-align:center;">
                    <td style="border: 1px solid;">'.$i.'</td>
                    <td style="border: 1px solid;">'.$row->pembelian_kode.'</td>
                    <td style="border: 1px solid;">'.$row->supplier->supplier_nama.'</td>
                    <td style="border: 1px solid;">'.$row->pembelian_detail[0]->total.'</td>
                    <td style="border: 1px solid;">'.convert_to_rupiah($row->pembelian_total).'</td>
                    <td style="border: 1px solid;">'.$row->user->name.'</td>
                    <td style="border: 1px solid;">'.date('d-m-Y', strtotime($row->created_at)).'</td>
                </tr>
            ';
            $i++;
        }

        $html .= '</table>';

        return $html;
    }

    public function getReportPembelian($filter)
    {
        $day        = date('d');
        $month      = date('m');
        $year       = date('Y');
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

        return $pembelian;
    }
}
