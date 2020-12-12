<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function formatRupiah($number, $prefix = false, $suffix = false) {
        return ($prefix ? "Rp. " : '') . number_format($number, 0, ',', '.') . ($suffix ? ',-' : '');
    }
    
}
