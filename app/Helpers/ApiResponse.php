<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Json response to invalid request.
     *
     * @param string $errorCode
     * @param int    $status
     * @param array  $headers
     * @param int    $options
     *
     * @return JsonResponse
     */
    public static function error(string $errorCode, int $status, array $headers = [], int $options = 0)
    {
        $json = [
            'code' => $errorCode,
        ];
        return new JsonResponse($json, $status, $headers, $options);
    }
}
