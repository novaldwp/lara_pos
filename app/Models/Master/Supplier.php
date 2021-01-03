<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction\Pembelian;

class Supplier extends Model
{
    public $incrementing = false;
    protected $table = "supplier";
    protected $primaryKey = "supplier_id";

    protected $fillable = [
        'supplier_nama',
        'supplier_alamat',
        'supplier_kontak',
        'supplier_phone',
        'supplier_website'
    ];

    public function produk(){
        return $this->belongsTo('App\Produk');
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class, 'supplier_id');
    }
}
