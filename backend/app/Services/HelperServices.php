<?php

namespace App\Services;

class HelperServices
{
    public function responseSuccess($data, $message = "Operation successful")
    {
        return response()->json(
            $data,
            200
        );
    }

    public function responseError($message = "An error occurred", $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}
