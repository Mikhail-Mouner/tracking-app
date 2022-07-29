<?php

namespace App\Helper\Response;

use Illuminate\Http\JsonResponse;

final class Json
{
    /**
     * @param string $message
     * @param mixed|null $data
     * @return JsonResponse
     */
    public static function success(string $message = 'Success!',  $data = null): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public static function error(string $message = 'Error!'): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], JsonResponse::HTTP_CONFLICT);
    }

}
