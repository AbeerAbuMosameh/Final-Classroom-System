<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Storage;

trait apiResoponse
{
    public function apiResponse($status ,$msg , $data,$code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $msg,
            'data' => $data,
        ], $code);
    }

}
