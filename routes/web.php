<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;

Route::get('/', function () {
    return view('home');
});


Route::get('/products', [ProductController::class, 'list'])->name('products_list');
Route::get('/minitest', function () {
    $bill = [
        'items' => [
            ['name' => 'Milk', 'price' => 10],
            ['name' => 'Bread', 'price' => 5]
        ],
        'total' => 15
    ];
    return view('minitest', compact('bill'));
});
Route::get('/transcript', function () {
    $transcript = [
        ['course' => 'Math', 'grade' => 85],
        ['course' => 'Science', 'grade' => 90]
    ];
    return view('transcript', compact('transcript'));
});