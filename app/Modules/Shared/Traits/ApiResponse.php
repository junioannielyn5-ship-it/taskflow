<?php

namespace App\Modules\Shared\Traits;

trait ApiResponse
{
    protected function sendResponse($data, $message = '', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function sendError($message = '', $status = 400, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
