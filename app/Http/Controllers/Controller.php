<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondSuccess($data = null, $message = "", $httpStatus = 200) {
        $response = [
            'status' => true,
            'message' => ($message == "") ? "Data diterima" : $message,
        ];
        if($data) $response['data'] = $data;

        return response()->json($response, $httpStatus);
    }
    
    protected function respondFailed($message = "", $httpStatus = 500) {
        return response()->json([
            'status' => false,
            'message' => ($message == "") ? "Terjadi kesalahan pada server" : $message
        ], $httpStatus);
    }

    protected function respondArray($data = null, $httpStatus = 200) {
        return response()->json($data, $httpStatus);
    }
}
