<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUserTransactions() {
        $user = User::whereEmail('testuser@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);
        
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.transaction.user'));

        $response->assertStatus(200);
    }

    public function testGetLaundromatTransactions() {
        $user = User::whereEmail('testowner@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.transaction'));

        $response->assertStatus(200);
    }
}
