<?php

namespace App\Http\Controllers;

use App\Repositories\interfaces\IOrderRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $orderRepository;

    public function __construct(
        IOrderRepository $orderRepository
    ){
        $this->middleware('auth:api');
        $this->orderRepository = $orderRepository;
    }

    /**
     * @desc Obtener todas las ordenes
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrders(){
        $orders = $this->orderRepository->all();
        if(count($orders) === 0){
           return $this->responseFail([],Response::HTTP_NO_CONTENT);
        }
        return $this->responseSuccess($orders);
    }

    /**
     * @desc Obtiene los datos de una orden según su id
     * @author Juan Pablo Camargo Vanegas
     * @param $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrder($orderId){
        try {
            $order = $this->orderRepository->find($orderId);
            $order->products;
            return $this->responseSuccess($order);
        }catch (\Exception $e){
            return $this->responseFail("order not found",Response::HTTP_NO_CONTENT);
        }
    }

    /**
     * @desc Obtiene los datos de una orden según su user id
     * @author Juan Pablo Camargo Vanegas
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrdersByUserId($userId){
        $orders = $this->orderRepository->orderByUserId($userId);
        if(count($orders) === 0){
            return $this->responseFail("orders by id not founds", Response::HTTP_NOT_FOUND);
        }
        return $this->responseSuccess($orders);
    }

    /**
     * @desc Crea una nueva orden, si esta contiene productos, crea las relaciones correspondientes
     * @author Juan Pablo Camargo Vanegas
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request){
        $this->validate($request, [
            'user_id' => 'required'
        ]);
        $newOrder = $this->orderRepository->create($request->all());
        if(empty($newOrder)){
            return $this->responseFail("order not created", Response::HTTP_NO_CONTENT);
        }
        return $this->responseSuccess([
            'message' => 'order created',
            'id' => $newOrder
        ]);
    }

    /**
     * @desc Actualiza una orden
     * @author Juan Pablo Camargo Vanegas
     * @param $orderId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update($orderId, Request $request){
            $this->validate($request,[
                'user_id' => 'required',
                'status' => 'required',
            ]);
            $order = $this->orderRepository->update($orderId, $request->toArray());
            if($order == 0){
                return $this->responseFail(" Order not updated ", Response::HTTP_NO_CONTENT);
            }
            return $this->responseSuccess($order);
    }
}
