<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');

Route::get('/', function () {
    return view('welcome'); // أو أي صفحة أخرى تريدها
})->name('home');


Route::get('/multable', function (Request $request) {
    $j = $request->number;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
})->name('multiplication');

Route::get('/even', function () {
    return view('even');
})->name('even');


Route::get('/prime', function () {
    return view('prime');
})->name('prime');

Route::get('/test', function () {
    return view('test');
});
Route::get('/minitest', function () {
    $bill = [
        'customer' => 'John Doe',
        'date' => date('Y-m-d'),
        'items' => [
            ['name' => 'Apples', 'quantity' => 2, 'price' => 1.5],
            ['name' => 'Bananas', 'quantity' => 3, 'price' => 0.75],
            ['name' => 'Milk', 'quantity' => 1, 'price' => 2.5],
        ],
    ];

    return view('minitest', compact('bill'));
})->name('minitest');



Route::get('/transcript', function () {
    return view('transcript');
})->name('transcript');
Route::get('/transcript', function () {
    $student = [
        'name' => 'Asmaa Saied',
        'id' => '230101389',
        'major' => 'Computer Science',
        'courses' => [
            ['name' => 'Mathematics', 'grade' => 'A+'],
            ['name' => 'Physics', 'grade' => 'A+'],
            ['name' => 'Programming', 'grade' => 'A-'],
        ],
    ];

    return view('transcript', compact('student'));
})->name('transcript');
