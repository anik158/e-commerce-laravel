<?php

namespace App\Traits;

trait ResponseStatus
{
    public function success($data = [], $message = 'success', $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ], $code);
    }

    public function error($message = 'error', $code = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}
