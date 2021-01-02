<?php

namespace App\Models\Master;

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
        return $this->hasOne(Produk::class, 'kategori_id');
    }

}
