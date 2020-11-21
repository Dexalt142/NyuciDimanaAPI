<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{

    use WithFaker;

    public function testRegister() {
        $response = $this->json('POST', route('api.auth.register'), [
            'name' => $this->faker('id_ID')->name(),
            'email' => $this->faker('id_ID')->email(),
            'password' => 'testuser',
            'phone_number' => $this->faker('id_ID')->phoneNumber(),
            'role' => rand(0, 1)
        ]);

        $response->assertStatus(200);
    }

    public function testLogin() {
        $response = $this->json('POST', route('api.auth.login'), [
            'email' => 'testuser@nyucidimanaapi.test',
            'password' => 'testuser'
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'status', 'message', 'data'
        ]);
    }

    public function testMe() {
        $user = User::whereEmail('testuser@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->get(route('api.auth.me'));

        $response->assertStatus(200);
    }

    public function testLogout() {
        $user = User::whereEmail('testuser@nyucidimanaapi.test')->first();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => "Bearer $token"])->post(route('api.auth.logout'));

        $response->assertStatus(200);
    }
}
