<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;

class Member extends Model
{
    protected $table = "members";
    protected $primaryKey = "member_id";

    protected $fillable = [
        'member_kode',
        'member_nama',
        'member_alamat',
        'member_kelamin',
        'member_hp'
    ];

    public static function get_id_member() {

        $year = date('Y'); // year now
        $month = date('m'); // month now
        // get last member_kode value
        $value          = DB::table('members')->select('member_kode')->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('member_id', 'ASC')->first();
        $take_year      = substr($value['member_kode'], 0, 4); //2019 taking a year string
        $take_month     = substr($value['member_kode'], 4, 2); //11 taking a month string
        $take_increment = substr($value['member_kode'], 6, 3); // 003 taking a increment string
        $default        = "001"; // default value for incrementing
        // if looping config
        if($year == $take_year)
        {
            // nested loop if condition 1 is true
            if($month == $take_month)
            {
                // do the "sum" between $value value and 1
                $member_kode = $value->member_kode + 1;
            }
            else{
                // if condition 2 fail then generate with same year different month with default value
                $member_kode = $year.$month.$default;
            }
        }
        else{
            // if condition 1 fail then generate with differet year and month with default value
            $member_kode = $year.$month.$default;
        }

        return $member_kode;
    }

}
