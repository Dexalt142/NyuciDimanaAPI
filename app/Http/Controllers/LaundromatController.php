<?php

namespace App\Http\Controllers;

use App\Laundromat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaundromatController extends Controller
{
    
    public function getLaundromats() {
        $laundromats = Laundromat::all();

        return response()->json([
            'status' => 200,
            'message' => 'Fetch success',
            'data' => $laundromats
        ]);
    }

    public function getLaundromat($id) {
        $laundromat = Laundromat::find($id);

        if($laundromat) {
            return response()->json([
                'status' => 200,
                'message' => 'Fetch success',
                'data' => $laundromat
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Laundromat not found',
        ], 404);
    }

    public function getUserLaundromat() {
        $user = auth()->user();

        if($user->role == 1) {
            $laundromat = $user->laundromat;

            if($laundromat) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Fetch success',
                    'data' => $laundromat
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Fetch failed'
                ], 404);
            }

        }

        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized'
        ], 401);
    }

    public function getLaundromatStatistic() {
        $user = auth()->user();

        if($user->role == 1) {
            $laundromat = $user->laundromat;

            if($laundromat) {
                $statistics = [
                    'total_transactions' => $laundromat->transactions->count(),
                    'revenue' => $this->formatRupiah($laundromat->transactions->sum('price'), true)
                ];

                return response()->json([
                    'status' => 200,
                    'message' => 'Fetch success',
                    'data' => $statistics
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Fetch failed'
                ], 404);
            }

        }

        return response()->json([
            'status' => 401,
            'message' => 'Unauthorized'
        ], 401);
    }

    public function createLaundromat(Request $request) {

        $attributes = [
            'name' => 'Nama',
            'address' => 'Alamat'
        ];

        $messages = [
            'required' => ':attribute tidak boleh kosong',
            'max' => ':attribute maksimal :max karakter'
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ], $messages, $attributes);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Create laundromat failed',
                'error' => $validator->errors()
            ], 400);
        }

        $user = auth()->user();
        $laundromat = $user->laundromat;
        if(!$laundromat) {
            $laundromat = Laundromat::create([
                'name' => $request->name,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 0,
                'user_id' => $user->id
            ]);
    
            if($laundromat->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Create laundromat success',
                    'data' => $laundromat
                ]);
            }
        }
        
        return response()->json([
            'status' => 400,
            'message' => 'Create laundromat failed'
        ], 400);
    }

}
