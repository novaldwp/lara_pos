<?php

namespace App\Exports;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportPenjualan implements FromCollection
{
    public function collection()
    {
        return Penjualan::all();
    }
}
