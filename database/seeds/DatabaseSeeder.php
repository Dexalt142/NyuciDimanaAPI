<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $defaultUser = User::create([
            'name' => 'Test User',
            'email' => 'testuser@nyucidimanaapi.test',
            'password' => Hash::make('testuser'),
            'phone_number' => '0812345678',
            'role' => 1
        ]);
    }
}
