<?php

namespace App\Exceptions;

use Exception;

class TortugaInernalException extends Exception
{
    /**
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        return response()->json([
            'error' => $this->getMessage()
        ]);
    }
}
