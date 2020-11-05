<?php

namespace App\Http\Controllers;

use App\Laundromat;
use Illuminate\Http\Request;

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

}
