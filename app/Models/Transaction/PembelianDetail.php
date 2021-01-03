<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Produk;
use App\Models\Transaction\Pembelian;

class PembelianDetail extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = "detailpembelian_id";
    protected $fillable = [
        'pembelian_id', 'produk_id', 'detailpembelian_jumlah', 'detailpembelian_subtotal'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id');
    }
}
