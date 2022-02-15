<?php

use App\Models\Orders;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tymon\JWTAuth\Facades\JWTAuth;


class OrderTest extends TestCase
{
    private const API_URL = "/v1/orders";

    /**
     * @test
     * @return void
     */
    public function user_may_get_all_orders(){
        $token = $this->getToken();
        $response = $this->json('GET', self::API_URL."?token=$token");
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            'success'=>true,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function user_may_get_one_order(){
        $user = User::first();
        $token = $this->getToken();
        $response = $this->json('GET', self::API_URL."/$user->id?token=$token");
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            'success'=>true,
        ]);
    }

    /**
     * @test
     * @return void
     */
    public function user_may_create_order(){
        $order = Orders::factory()->make();
        $token = $this->getToken();
        $response = $this->json('POST', self::API_URL."/create?token=$token", $order->toArray());
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
                'success'=>true,
                'message' => "order created"
            ]);
    }

    private function getToken(){
        $user = User::factory()->make();
        $token = auth()->attempt([
            'email' => $user->email,
            'password' => $user->password
        ]);
        return $token;
    }
}
