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
    
    public function testCreateTransaction() {
        $user = User::whereEmail('testowner@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);
    
        $weight = rand(1, 5);
        $price = 2500 * $weight;

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->post(route('api.transaction.create'), [
            'weight' => $weight,
            'price' => $price,
            'start_date' => \Carbon\Carbon::now()->format('m/d/Y H:i:s')
        ]);

        $response->assertStatus(200);

    }
}
