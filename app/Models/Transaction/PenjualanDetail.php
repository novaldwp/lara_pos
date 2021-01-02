<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Produk;
use App\Models\Transaction\Penjualan;

class PenjualanDetail extends Model
{
    protected $table = "penjualan_detail";
    protected $primaryKey = "detailpenjualan_id";


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}


