<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimeController extends Controller
{
    public function showPrimeNumbers()
    {
        return view('prime')->with('isPrime', function($number) {
            if ($number < 2) return false;
            for ($i = 2; $i <= sqrt($number); $i++) {
                if ($number % $i == 0) return false;
            }
            return true;
        });
    }
}
