<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = "detailpembelian_id";
    protected $fillable = [
        'pembelian_id', 'produk_id', 'detailpembelian_jumlah', 'detailpembelian_subtotal'
    ];
}
