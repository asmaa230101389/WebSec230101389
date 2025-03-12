<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;

Route::get('/', function () {
    return view('home');
});


Route::get('/products', [ProductController::class, 'list'])->name('products_list');