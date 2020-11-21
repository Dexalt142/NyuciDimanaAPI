<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
