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
            $transactions = $user->transactions()->orderBy('created_at', 'DESC')->get();

            $transactions = $transactions->map(function($transaction) {
                $transaction->price = $this->formatRupiah($transaction->price, true);
                $transaction->weight = $this->formatRupiah($transaction->weight)." Kg";
                $transaction->start_date_format = $transaction->start_date->format("d M Y H:i");
                $transaction->end_date_format = "-";
                if($transaction->end_date) {
                    $transaction->end_date_format = $transaction->end_date->format("d M Y H:i");
                }

                return $transaction;
            });

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
                $transactions = $laundromat->transactions()->orderBy('created_at', 'DESC')->get();

                $transactions = $transactions->map(function($transaction) {
                    $transaction->price = $this->formatRupiah($transaction->price, true);
                    $transaction->weight = $this->formatRupiah($transaction->weight)." Kg";
                    $transaction->start_date_format = $transaction->start_date->format("d M Y H:i");
                    $transaction->end_date_format = "-";
                    if($transaction->end_date) {
                        $transaction->end_date_format = $transaction->end_date->format("d M Y H:i");
                    }

                    return $transaction;
                });

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
                $transaction->user;

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
                'price' => 'Harga'
            ];
    
            $messages = [
                'required' => ':attribute tidak boleh kosong',
            ];
    
            $validator = Validator::make($request->all(), [
                'weight' => 'required',
                'price' => 'required',
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
                'start_date' => now(),
                'status' => 0,
                'laundromat_id' => $laundromat->id,
            ]);

            if($transaction->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Create transaction success',
                    'data' => $transaction
                ]);
            }
        }


        return response()->json([
            'status' => 400,
            'message' => 'Create transaction failed'
        ], 400);
    }

    public function updateTransactionStatus(Request $request) {
        $user = auth()->user();

        if ($user->isLaundromatOwner()) {
            $attributes = [
                'id' => 'Id',
                'code' => 'Kode',
                'status' => 'Status'
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong',
                'exists' => ':attribute tidak terdaftar',
                'in' => ':attribute tidak ditemukan'
            ];

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:transactions,id',
                'code' => 'required|exists:transactions,transaction_code',
                'status' => 'required|in:process,done'
            ], $messages, $attributes);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Update transaction failed',
                    'error' => $validator->errors()
                ], 400);
            }

            $laundromat = $user->laundromat;
            $transaction = $laundromat->transactions->where('id', $request->id)->where('transaction_code', $request->code)->first();

            if(!$transaction) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Update transaction failed'
                ], 400);
            }

            if($request->status == "process") {
                $transaction->status = 1;
            } else if($request->status == "done") {
                $transaction->status = 2;
                $transaction->end_date = now();
            }

            if ($transaction->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Update transaction success',
                    'data' => $transaction
                ]);
            }
        }


        return response()->json([
            'status' => 400,
            'message' => 'Update transaction failed'
        ], 400);
    }

    public function attachTransaction(Request $request) {
        $user = auth()->user();

        if(!$user->isLaundromatOwner()) {
            $attributes = [
                'id' => 'Id',
                'code' => 'Kode',
            ];

            $messages = [
                'required' => ':attribute tidak boleh kosong',
                'exists' => ':attribute tidak terdaftar',
                'in' => ':attribute tidak ditemukan'
            ];

            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:transactions,id',
                'code' => 'required|exists:transactions,transaction_code'
            ], $messages, $attributes);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Attach transaction failed',
                    'error' => $validator->errors()
                ], 400);
            }

            $transaction = Transaction::where('id', $request->id)->where('transaction_code', $request->code)->first();

            if($transaction) {
                if(!$transaction->user_id) {
                    $transaction->user_id = $user->id;

                    if ($transaction->save()) {
                        return response()->json([
                            'status' => 200,
                            'message' => 'Attach transaction success',
                            'data' => $transaction
                        ]);
                    }
                }
            }
        }

        return response()->json([
            'status' => 400,
            'message' => 'Attach transaction failed'
        ], 400);
    }

}
