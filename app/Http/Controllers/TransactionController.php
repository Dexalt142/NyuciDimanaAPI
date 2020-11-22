<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
