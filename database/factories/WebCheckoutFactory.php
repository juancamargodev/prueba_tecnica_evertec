<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\WebCheckouts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WebCheckoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WebCheckouts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(){
        return [
            'order_id' => factory(Orders::class),
            'payment_data' => $this->fakePaymentData()
        ];
    }

    /**
     * return fake payment data to add in factory
     * @return false|string
     */
    private function fakePaymentData():string{
        $paymentData = new \stdClass();
        $paymentData->locale = "es_Co";
        $paymentData->auth->login = "c51ce410c124a10e0db5e4b97fc2af39";
        $paymentData->auth->tranKey = "VQOcRcVH2DfL6Y4B4SaK6yhoH/VOUveZ3xT16OQnvxE=";
        $paymentData->auth->nonce =  "NjE0OWVkODgwYjNhNw==";
        $paymentData->auth->seed = Carbon::now();
        $paymentData->reference = Str::random(10);
        $paymentData->description = "test";
        $paymentData->amount->currency = "COP";
        $paymentData->amount->total = 10000;
        $paymentData->allowPartial = false;
        $paymentData->expiration = Carbon::now()->addDay();
        $paymentData->returnUrl = $this->faker->url;
        $paymentData->ipAddress = "127.0.0.1";
        $paymentData->userAgent = "PlacetoPay Sandbox";

        return json_encode($paymentData);
    }
}
