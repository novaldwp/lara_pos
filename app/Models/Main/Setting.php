<?php

namespace App\Models\Main;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table  = "setting";
    protected $primaryKey = "setting_id";
    protected $increments = false;
}
