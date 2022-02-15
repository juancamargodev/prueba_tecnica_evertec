<?php

use App\Models\User;

class ProductTest extends TestCase
{
    private const API_URL = "/v1/products";

    /**
     * @test
     * @return void
     */
    public function user_may_get_all_products(){
        $token = $this->getToken();
        $response = $this->json('GET', self::API_URL."?token=$token");
        $response->assertResponseStatus(200);
        $response->seeJsonContains([
            'success'=>true,
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
