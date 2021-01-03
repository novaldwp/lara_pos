<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Master\Supplier;
use App\User;
use App\Models\Transaction\PembelianDetail;

class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $primaryKey = "pembelian_id";
    protected $fillable = [
        'pembelian_kode', 'supplier_id', 'pembelian_total', 'user_id'

    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class, 'pembelian_id');
    }
}
