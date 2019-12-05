<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembelian extends Model
{
    protected $table = "pembelian";
    protected $primaryKey = "pembelian_id";
    protected $fillable = [
        'pembelian_kode', 'supplier_id'

    ];

    public static function get_pembelian_kode()
    {

        $year       = date('Y'); // year now
        $month      = date('m'); // month now
        $default    = "0001"; // default value for incrementing
        $key        = "PMB";
        $count      = DB::table('pembelian')->count();
        if($count > 0)
        {
            // get last pembelian_kode value
            $value_kode      = DB::table('pembelian')->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('pembelian_id', 'ASC')->get()->last()->pembelian_kode;
            $take_numeric   = substr($value_kode, 3, 10); //2019110003 from PMB2019110003
            $take_year      = substr($take_numeric, 0, 4); //2019 taking a year string
            $take_month     = substr($take_numeric, 4, 2); //11 taking a month string
            $take_increment = substr($take_numeric, 6, 3); // 003 taking a increment string
            // if looping config
            if($year == $take_year)
            {
                // nested loop if condition 1 is true
                if($month == $take_month)
                {
                    // do the "sum" between $test value and 1
                    $pembelian_kode = $take_numeric + 1;
                }
                else{
                    // if condition 2 fail then generate with same year different month with default value
                    $pembelian_kode = $year.$month.$default;
                }
            }
            else{
                // if condition 1 fail then generate with differet year and month with default value
                $pembelian_kode = $year.$month.$default;
            }
        }
        else{
            $pembelian_kode = $year.$month.$default;
        }

        return $key.$pembelian_kode;
    }
}
