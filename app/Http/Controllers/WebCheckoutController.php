<?php

namespace App\Http\Controllers;

use App\Repositories\interfaces\IOrderRepository;
use App\Repositories\interfaces\IUserRepository;
use App\Repositories\interfaces\IWebCheckoutRepository;
use App\Services\WebCheckoutService;
use App\Traits\WebCheckoutTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class WebCheckoutController extends Controller
{
    use WebCheckoutTrait;

    private $orderRepository;
    private $userRepository;
    private $webCheckoutService;
    private $webCheckoutRepository;

    public function __construct(
        IOrderRepository $orderRepository,
        IUserRepository  $userRepository,
        IWebCheckoutRepository $webCheckoutRepository,
        WebCheckoutService $webCheckoutService
    ){
        $this->middleware('auth:api');
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->webCheckoutService = $webCheckoutService;
        $this->webCheckoutRepository = $webCheckoutRepository;
    }

    //paga las ordenes del cliente
    /**
     * @desc Genera la data necesaria para iniciar sesión en el web checkout service
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function payOrder(Request $request){
        $this->validate($request, [
           'order_id' => 'required',
           'user_id' => 'required',
            'total' => 'required',
            'description' => 'required',
            'reference' => 'required'
        ]);

        $order = $this->orderRepository->validateOrderAndUser($request->order_id,$request->user_id);
        $user = $this->userRepository->find($request->user_id);
        if(!$order){
            return $this->responseFail('order not found', Response::HTTP_NO_CONTENT);
        }
        if(!$user){
            return $this->responseFail('user not found', Response::HTTP_NO_CONTENT);
        }
        $request->merge([
           'userData' => $user->toArray(),
           'order' => $order->toArray(),
            'ip' => $request->ip()
        ]);
        $response = $this->webCheckoutService->createRequest($request->toArray());

        if($response->status->status !== "OK"){
            $message = $response->status->message;
            return $this->responseFail($message,Response::HTTP_UNAUTHORIZED);
        }
        unset($response->status);
        return $this->responseSuccess($response);
    }

    /**
     * @desc Genera la data necesaria para consultar el estado de la orden en el web checkout service
     * @author Juan Pablo Camargo Vanegas
     * @return \Illuminate\Http\JsonResponse
     */
    public function stateOrder(Request $request){
        $this->validate($request, [
            'order_id' => 'required'
        ]);

        $webCheckoutData = $this->webCheckoutRepository->findByOrder($request->order_id);
        if(!$webCheckoutData){
            return $this->responseSuccess();
        }
        $requestId = json_decode($webCheckoutData->payment_response)->requestId;
        $request->merge([
            'order_id' => $request->order_id,
            'requestId' => $requestId
        ]);
        $response = $this->webCheckoutService->getRequestInformation($request->toArray());
        unset($response->payment);
        $stateResponse = $this->getState($response->status->status);
        $user_id = \auth()->user()->id;
        $dataUpdate = [
            'user_id' => $user_id,
            'status' => $stateResponse
        ];
        $this->orderRepository->update($request->order_id, $dataUpdate);
        return $this->responseSuccess($response);
    }


}
