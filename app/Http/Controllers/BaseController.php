<?php

namespace App\Http\Controllers;

/**
 * Class BaseController
 *
 * @package App\Http\Controllers
 */
class BaseController extends Controller
{
    /**
     * @param  null    $data
     * @param  string  $message
     * @param  int     $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response($data = NULL, string $message = '', int $code = 501)
    {
        return response()->json([
            "data" => $data,
            "message" => $message
        ], $code);
    }
}
