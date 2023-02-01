<?php


namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * create success json response
     *
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public static function success($data): JsonResponse
    {
        return response()->json([
            "status"  => 200,
            "results" => $data,
        ]);
    }



    /**
     * create a json response with status 400
     *
     * @param string $message
     * @param array  $errors
     * @param int    $error_code
     *
     * @return JsonResponse
     */
    public static function clientError(string $message, array $errors = [], int $error_code = 400): JsonResponse
    {
        return response()->json([
            "status"           => 400,
            "userMessage"      => trans("userMessages.$message"),
            "developerMessage" => trans("developerMessages.$message"),
            "errorCode"        => $error_code,
            "moreInfo"         => null,
            "errors"           => $errors,
        ], $error_code);
    }



    /**
     * create a json response with status 500
     *
     * @param string $message
     * @param array  $errors
     * @param int    $error_code
     *
     * @return JsonResponse
     */
    public static function serverError(string $message, array $errors = [], int $error_code = 507)
    {
        return response()->json([
            "status"           => 500,
            "userMessage"      => trans("userMessages.$message"),
            "developerMessage" => trans("developerMessages.$message"),
            "errorCode"        => $error_code,
            "moreInfo"         => null,
            "errors"           => $errors,
        ], $error_code);
    }
}
