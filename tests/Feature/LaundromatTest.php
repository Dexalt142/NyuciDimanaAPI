<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LaundromatTest extends TestCase
{

    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateLaundromat() {

        $user = User::whereEmail('testowner@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->json('POST', route('api.laundromat.create'), [
            'name' => $this->faker('id_ID')->firstName()." Laundry",
            'address' => $this->faker('id_ID')->address(),
            'latitude' => '-6.901235',
            'longitude' => ' 107.618699'
        ]);

        $response->assertStatus(200);
    }

    public function testGetAllLaundromats() {
        $user = User::whereEmail('testuser@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.laundromat'));

        $response->assertStatus(200);
    }

    public function testGetLaundromat() {
        $user = User::whereEmail('testuser@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.laundromat.get', [1]));

        $response->assertStatus(200);
    }

    public function testGetUserLaundromat() {
        $user = User::whereEmail('testowner@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.laundromat.my'));

        $response->assertStatus(200);
    }
}
