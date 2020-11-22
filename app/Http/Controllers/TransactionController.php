<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    
    public function getUserAllTransactions() {
        
        $user = auth()->user();

        if(!$user->isLaundromatOwner()) {
            $transactions = $user->transactions;
    
            return response()->json([
                'status' => 200,
                'message' => 'Fetch success',
                'data' => $transactions
            ]);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Fetch failed'
        ], 401);

    }

    public function getUserTransaction($id) {

        $user = auth()->user();

        if(!$user->isLaundromatOwner()) {
            $transactions = $user->transactions;
            $transaction = $transactions->where('id', $id)->first();

            if($transaction) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Fetch success',
                    'data' => $transaction
                ]);
            }

            return response()->json([
                'status' => 404,
                'message' => 'Fetch failed, transaction not found'
            ], 404);
        }

        return response()->json([
            'status' => 401,
            'message' => 'Fetch failed'
        ], 401);

    }

    public function getLaundromatAllTransactions() {

        $user = auth()->user();

        if($user->isLaundromatOwner()) {
            $laundromat = $user->laundromat;

            if($laundromat) {
                $transactions = $laundromat->transactions;

                return response()->json([
                    'status' => 200,
                    'message' => 'Fetch success',
                    'data' => $transactions
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Fetch failed, laundromat not found'
            ], 400);
    
        }

        return response()->json([
            'status' => 401,
            'message' => 'Fetch failed'
        ], 401);

    }

    public function getLaundromatTransaction($id) {

        $user = auth()->user();

        if($user->isLaundromatOwner()) {
            $laundromat = $user->laundromat;

            if($laundromat) {
                $transactions = $laundromat->transactions;
                $transaction = $transactions->where('id', $id)->first();

                if($transaction) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Fetch success',
                        'data' => $transaction
                    ]);
                }

                return response()->json([
                    'status' => 404,
                    'message' => 'Fetch failed, transaction not found'
                ], 404);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Fetch failed, laundromat not found'
            ], 400);
    
        }

        return response()->json([
            'status' => 401,
            'message' => 'Fetch failed'
        ], 401);

    }

    public function createTransaction(Request $request) {

        $user = auth()->user();

        if($user->isLaundromatOwner()) {
            $attributes = [
                'weight' => 'Berat',
                'price' => 'Harga',
                'start_date' => 'Tanggal mulai'
            ];
    
            $messages = [
                'required' => ':attribute tidak boleh kosong',
            ];
    
            $validator = Validator::make($request->all(), [
                'weight' => 'required',
                'price' => 'required',
                'start_date' => 'required|date',
            ], $messages, $attributes);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Create transaction failed',
                    'error' => $validator->errors()
                ], 400);
            }
    
            $laundromat = $user->laundromat;
            $transaction = Transaction::create([
                'transaction_code' => Str::random(10),
                'weight' => $request->weight,
                'price' => $request->price,
                'start_date' => $request->start_date,
                'status' => 0,
                'laundromat_id' => $laundromat->id,
            ]);

            if($transaction->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Create transaction success',
                    'data' => $transaction
                ], 200);
            }
        }


        return response()->json([
            'status' => 400,
            'message' => 'Create transaction failed'
        ], 400);
    }

}
