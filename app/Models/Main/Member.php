<?php

namespace App\Models\Main;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;
use App\Models\Transaction\Penjualan;

class Member extends Model
{
    protected $table = "member";
    protected $primaryKey = "member_id";

    protected $fillable = [
        'member_kode',
        'member_nama',
        'member_phone',
        'member_alamat'
    ];

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'member_id');
    }
}
