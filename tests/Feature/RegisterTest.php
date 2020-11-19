<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', route('api.auth.register'), [
            'name' => $this->faker('id_ID')->name(),
            'email' => $this->faker('id_ID')->email(),
            'password' => 'testuser',
            'phone_number' => $this->faker('id_ID')->phoneNumber(),
            'role' => rand(0, 1)
        ]);

        $response->assertStatus(200);
    }
}
