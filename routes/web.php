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
Route::get('/calculator', function () {
    return view('calculator');
});
Route::post('/calculator', function (Illuminate\Http\Request $request) {
    $num1 = $request->input('num1');
    $num2 = $request->input('num2');
    $operation = $request->input('operation');
    $result = 0;

    switch ($operation) {
        case 'add':
            $result = $num1 + $num2;
            break;
        case 'subtract':
            $result = $num1 - $num2;
            break;
        case 'multiply':
            $result = $num1 * $num2;
            break;
        case 'divide':
            $result = $num2 != 0 ? $num1 / $num2 : 'Error: Division by zero';
            break;
    }

    return view('calculator', compact('result', 'num1', 'num2', 'operation'));
});
Route::get('/gpa', function () {
    return view('gpa');
});
Route::post('/gpa', function (Illuminate\Http\Request $request) {
    $grades = $request->input('grades', []);
    $hours = $request->input('hours', []);
    $totalPoints = 0;
    $totalHours = 0;

    for ($i = 0; $i < count($grades); $i++) {
        $totalPoints += $grades[$i] * $hours[$i];
        $totalHours += $hours[$i];
    }

    $gpa = $totalHours > 0 ? $totalPoints / $totalHours : 0;
    return view('gpa', compact('gpa', 'grades', 'hours'));
});