<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendInsert()
    {
        return response()->json([
            'message' => "Data Berhasil Ditambahkan."
        ]);
    }

    public function sendUpdate()
    {
        return response()->json([
            'message'   => "Data Berhasil Diubah."
        ], 200);
    }

    public function sendDelete()
    {
        return response()->json([
            'message'   => "Data Berhasil Dihapus."
        ], 200);
    }
}
