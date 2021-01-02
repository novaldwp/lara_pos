<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;

use App\Models\Master\Produk;

class PenjualanDummy extends Model
{
    protected $table = "penjualan_dummy";
    protected $primaryKey = "dummy_id";

    protected $fillable = [
        'dummy_qty', 'dummy_harga', 'dummy_subtotal', 'produk_id'
    ];

    function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
