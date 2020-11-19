<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
    
    public function register(Request $request) {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Register failed',
                'error' => $validator->errors()
            ], 400);
        }

        try {
            $user = $this->createUser($request->all());

            if ($user) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Register success'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    protected function validator($data) {

        $attributes = [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'phone_number' => 'No. Telepon'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal :min karakter',
            'role.min' => 'Role tidak ditemukan',
            'role.max' => 'Role tidak ditemukan',
        ];

        return Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string',
            'role' => 'required|integer|min:0|max:1'
        ], $messages, $attributes);
    }

    protected function createUser($data) {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'role' => $data['role'],
        ]);

        return $user;
    }

}
