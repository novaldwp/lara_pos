<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table = "stok";
    protected $primaryKey = "stok_id";
    protected $fillable = [
        'stok_jumlah',
        'produk_id'
    ];

    public function produk(){
        return $this->belongsTo(Produk::class, 'produk_id');
    }


}
