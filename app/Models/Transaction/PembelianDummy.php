<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Produk;

class PembelianDummy extends Model
{
    protected $table = "pembelian_dummy";
    protected $primaryKey = "pembeliandummy_id";
    protected $fillable = array(
        'produk_id', 'pembelian_jumlah', 'produk_beli', 'subtotal'
    );

    function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }



}
