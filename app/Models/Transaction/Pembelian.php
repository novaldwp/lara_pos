<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $primaryKey = "pembelian_id";
    protected $fillable = [
        'pembelian_kode', 'supplier_id'

    ];


}
