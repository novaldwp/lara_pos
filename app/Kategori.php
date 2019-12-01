<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $primaryKey = "kategori_id";
    public $incrementing = false;

    protected $fillable = [
        'kategori_nama'
    ];

    public function produk(){
        return $this->belongsTo('App\Produk');
    }

}
