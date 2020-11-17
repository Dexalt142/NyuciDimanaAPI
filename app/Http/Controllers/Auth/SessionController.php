<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SessionController extends Controller {
    
    public function getUser() {
        $user = auth()->user();
        
        if($user) {
            return response()->json([
                'status' => 200,
                'message' => 'Fetch user success',
                'data' => $user
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Fetch user failed'
        ], 400);
    }

    public function logout() {
        try {
            JWTAuth::parseToken()->invalidate();

            return response()->json([
                'status' => 200,
                'message' => 'Logout success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error'
            ], 500);
        }
    }

}
