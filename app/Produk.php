<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
        'produk_gambar',
        'kategori_id',
    ];

    public static function generate_produk_kode(){

        $stok       = DB::table('produk')->orderBy('produk_id', 'DESC')->select('produk_kode')->first();

        $kode       = $stok->produk_kode;
        $increment  = sprintf("%03s",substr($kode, 4, 3) + 1 );
        $alphabet   = substr($kode, 0, 4);

        $new_kode   = $alphabet.$increment;

        return $new_kode;
    }

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function stok(){
        return $this->hasOne(Stok::class, 'produk_id');
    }

    public function pembeliandummy(){
        return $this->hasOne(PembelianDummy::class, 'produk_id');
    }

    public function penjualandummy(){
        return $this->hasOne(PenjualanDummy::class, 'produk_id');
    }



}
