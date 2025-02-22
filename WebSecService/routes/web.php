<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function () {
    return view('multable', ['j' => 5]);
});

Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});
use App\Http\Controllers\EvenController;

Route::get('/even', [EvenController::class, 'showEvenNumbers']);


use App\Http\Controllers\PrimeController;

Route::get('/prime', [PrimeController::class, 'showPrimeNumbers']);
