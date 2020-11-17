<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller {
    
    public function login(Request $request) {
        $validator = $this->validator($request->all());

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Login failed',
                'error' => $validator->errors()
            ], 400);
        }

        try {
            if(!$token = auth()->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Login failed',
                    'error' => [
                        'email' => ['Email atau password salah']
                    ]
                ], 400);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error',
            ], 500);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Login success',
            'data' => [
                'token' => $token
            ]
        ]);
    }

    protected function validator($data) {

        $attributes = [
            'email' => 'Email',
            'password' => 'Password'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'email.exists' => 'Email atau password salah'
        ];

        return Validator::make($data, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ], $messages, $attributes);
    }

}
