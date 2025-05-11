<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    public function sendSuccessResponse($data, $msg, $status)
    {
        return response()->json(
            [
                "success" => true,
                "status" => $status ?? 200,
                "data" => $data,
                "message" => $msg ?? "Success."
            ],
            $status ?? 200
        );
    }

    public function sendErrorResponse($msg, $status)
    {
        return response()->json([
            "success" =>  false,
            "status" => $status ?? 400,
            "message" => $msg ?? "Something went wrong. Please try again!"
        ], $status ?? 400);
    }
}
