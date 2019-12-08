<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $primaryKey = "penjualan_id";

    protected $fillable = [
        'penjualan_kode', 'is_payed', 'user_id'
    ];
}
