<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
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
