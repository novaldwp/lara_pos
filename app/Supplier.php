<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $incrementing = false;
    protected $table = "supplier";
    protected $primaryKey = "supplier_id";

    protected $fillable = [
        'supplier_nama',
        'supplier_alamat',
        'supplier_kontak',
        'supplier_telpon',
        'supplier_website'
    ];

    public function produk(){
        return $this->belongsTo('App\Produk');
    }
}