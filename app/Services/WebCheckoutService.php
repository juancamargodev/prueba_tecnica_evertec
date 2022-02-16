<?php

namespace App\Services;

use App\Repositories\interfaces\IWebCheckoutRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Http\Request;

class WebCheckoutService
{
    private $webCheckoutRepository;
    private $client;
    private $login;
    private $secretKey;
    private $locale;
    private $currency;
    private $seed;
    private $agent;
    private $url;

    public function __construct(
        IWebCheckoutRepository $webCheckoutRepository,
        Client $client
    ){
        $this->webCheckoutRepository = $webCheckoutRepository;
        $this->client = $client;
        $this->login = env('PLACETO_LOGIN_KEY');
        $this->secretKey = env('PLACETO_SECRET');
        $this->currency = env('PLACETO_CURRENCY');
        $this->locale = env('PLACETO_LOCALE');
        $this->agent = "PlacetoPay Sandbox";
        $this->url = env('PLACETO_URL');
        $this->seed = date('c');
    }

    /**
     * @desc consume el método CreateRequest del web checkout
     * @author Juan Pablo Camargo Vanegas
     * @param Request $request
     * @return void
     */
    public function createRequest(array $request){
        $validator = Validator::make($request,[
            'order_id' => 'required',
            'userData' => 'required',
            'order' => 'required',
            'total' => 'required',
            'description' => 'required',
            'reference' => 'required',
            'returnUrl' => 'required',
            'ip' => 'required'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        $amount = new \stdClass();
        $amount->currency = $this->currency;
        $amount->total = $request['total'];

        $payment = new \stdClass();
        $payment->reference = $request['reference'];
        $payment->description = $request['description'];
        $payment->amount = $amount;

        $webCheckoutInfo = new \stdClass();
        $webCheckoutInfo->locale = $this->locale;
        $webCheckoutInfo->auth = $this->generateAuthObject($this->generateNonce());
        $webCheckoutInfo->payment = $payment;
        $webCheckoutInfo->allowPartial = false;
        $webCheckoutInfo->expiration = Carbon::now()->addDays(2)->toIso8601String();
        $webCheckoutInfo->returnUrl = $request['returnUrl'];
        $webCheckoutInfo->ipAddress = $request['ip'];
        $webCheckoutInfo->userAgent = $this->agent;

        $response = $this->sendRequest($webCheckoutInfo,'/session');
        return $this->saveResponse($webCheckoutInfo,$response,$request['order_id']);
    }

    /**
     * @desc Consume el método getRequestInformation del web checkout
     * @author Juan Pablo Camargo Vanegas
     * @param array $request
     * @return \Illuminate\Support\MessageBag|mixed
     */
    public function getRequestInformation(array $request){
        $validator = Validator::make($request,[
            'requestId' => 'required',
            'order_id' => 'required'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        $auth = new \stdClass();
        $auth->auth = $this->generateAuthObject($this->generateNonce());
        $response = $this->sendRequest($auth,"/session/{$request['requestId']}");
        return $this->saveResponse($auth,$response,$request['order_id']);
    }

    /**
     * *@desc Genera el nonce para la consulta
     * @author Juan Pablo Camargo Vanegas
     * @return string
     * @throws \Exception
     */
    private function generateNonce():string{
        return bin2hex(random_bytes(16));
    }

    /**
     * @desc Genera el objeto de autenticación
     * @author Juan Pablo Camargo Vanegas
     * @param $nonce
     * @return \stdClass
     */
    private function generateAuthObject($nonce):\stdClass{
        $authObject = new \stdClass();
        $authObject->login = $this->login;
        $authObject->tranKey = $this->generateTranKey($nonce);
        $authObject->nonce = base64_encode($nonce);
        $authObject->seed = $this->seed;
        return $authObject;
    }

    /**
     * @desc Genera la llave para la autenticación
     * @author Juan Pablo Camargo Vanegas
     * @param $nonce
     * @return string
     */
    private function generateTranKey(string $nonce):string{
        $tranKey = $nonce . $this->seed . $this->secretKey;
        return base64_encode(sha1($tranKey,true));
    }

    /**
     * @desc Envía la petición a la url solicitada
     * @author Juan Pablo Camargo Vanegas
     * @param $data
     * @param $route
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest($data,$route = ''){
        $request = $this->client->request(
            'POST',
            $this->url.$route,
            [
                'json' => $data
            ]
        );
        return $request->getBody();
    }

    /**
     * @desc almacena los datos del web checkout
     * @author Juan Pablo Camargo Vanegas
     * @param $request
     * @param $response
     * @param int $orderId
     * @return mixed
     */
    private function saveResponse($request,$response,int $orderId){
        $objectResponse = json_decode($response);
        $webCheckoutData = [];
        $webCheckoutData['order_id'] = $orderId;
        $webCheckoutData['payment_request'] = json_encode($request);
        $webCheckoutData['payment_response'] = $response;
        if($objectResponse->status->status === "OK"){
            $webCheckoutData['payment_url'] = $objectResponse->processUrl;
        }
        $this->webCheckoutRepository->create($webCheckoutData);
        $requestUrl = $this->webCheckoutRepository->getrequestUrl($orderId);
        $objectResponse->requestUrl = $requestUrl->payment_url;
        return $objectResponse;
    }

}
