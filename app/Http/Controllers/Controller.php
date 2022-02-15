<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @desc Formatea la respuesta exitosa
     * @author Juan Pablo Camargo Vanegas
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data = [], $code = Response::HTTP_OK)
    {
        return response()
            ->json(['code' => $code,
                'success' => true,
                'data' => $data]);
    }

    /**
     * @desc Formatea la respuesta fallida
     * @author Juan Pablo Camargo Vanegas
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseFail($data = [], $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        return response()
            ->json(['code' => $code,
                'success' => false,
                'message' => $data], $code);
    }
}
