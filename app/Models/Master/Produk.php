<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\Main\Stok;
use App\Models\Transaction\Penjualandetail;

class Produk extends Model
{
    public $incrementing = false;
    protected $table        = "produk";
    protected $primaryKey   = "produk_id";
    protected $fillable     = [
        'produk_kode',
        'produk_nama',
        'produk_beli',
        'produk_jual',
        'produk_image',
        'kategori_id',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function stok(){
        return $this->hasOne(Stok::class, 'produk_id');
    }

    public function penjualandetail()
    {
        return $this->hasMany(Penjualandetail::class, 'produk_id');
    }

    public function pembeliandummy(){
        return $this->hasOne(PembelianDummy::class, 'produk_id');
    }

    public function penjualandummy(){
        return $this->hasOne(PenjualanDummy::class, 'produk_id');
    }



}
