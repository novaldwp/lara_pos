<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Main\Member;
use App\Models\Transaction\Penjualan;
use App\Models\Transaction\PenjualanDetail;

class Penjualan extends Model
{
    protected $table = "penjualan";
    protected $primaryKey = "penjualan_id";

    protected $fillable = [
        'penjualan_kode', 'penjualan_total', 'penjualan_nominal', 'penjualan_kembalian', 'member_id'
    ];

    public function penjualan_detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
