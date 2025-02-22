<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvenController extends Controller
{
    public function showEvenNumbers()
    {
        $evenNumbers = [];
        for ($i = 1; $i <= 100; $i++) {
            if ($i % 2 == 0) {
                $evenNumbers[] = $i;
            }
        }
        return view('even', compact('evenNumbers'));
    }
}
