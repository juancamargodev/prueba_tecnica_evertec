<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;


class AuthTest extends TestCase
{
    private const API_URL = "/v1/auth";

    /**
     * @test
     * @return void
     */
    public function a_user_may_login(){
        $user = User::factory()->make();
        $response = $this->json('POST', self::API_URL.'/login',$user->toArray());
        $response->assertResponseStatus(200);
        $response->seeJson([
            'expires_in' => 86400,
            'token_type' => 'bearer'
        ]);
    }



}
