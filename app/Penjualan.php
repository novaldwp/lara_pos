<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $primaryKey = "penjualan_id";

    protected $fillable = [
        'penjualan_kode', 'penjualan_total', 'penjualan_nominal', 'penjualan_kembalian', 'member_id'
    ];
}
