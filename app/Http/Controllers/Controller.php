<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Format number to Rupiah
     *
     * @param integer $number
     * @param boolean $prefix
     * @param boolean $suffix
     * @return string
     */
    public function formatRupiah($number, $prefix = false, $suffix = false) {
        return ($prefix ? "Rp. " : '') . number_format($number, 0, ',', '.') . ($suffix ? ',-' : '');
    }

    /**
     * Measure distance between two coordinates using Haversine formula
     *
     * @param float $lat1
     * @param float $long1
     * @param float $lat2
     * @param float $long2
     * @return float $distance
     * 
     */
    public function measureDistance($lat1, $long1, $lat2, $long2) {
        $earthRadius = 6371;

        $latDistance = deg2rad($lat2 - $lat1);
        $longDistance = deg2rad($long2 - $long1);

        $a = sin($latDistance/2) * sin($latDistance/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($longDistance/2) * sin($longDistance/2);
        $c = 2 * asin(sqrt($a));
        $distance = $earthRadius * $c * 1000;

        return $distance;
    }
    
}
