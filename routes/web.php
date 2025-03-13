<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\QuestionController;

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

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'doRegister'])->name('do_register');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UserController::class, 'doLogout'])->name('do_logout');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'list'])->name('users_list');
    Route::get('/users/form/{id?}', [UserController::class, 'form'])->name('users_form');
    Route::post('/users/save/{id?}', [UserController::class, 'save'])->name('users_save');
    Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users_delete');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile'); // تأكدي إنه موجود هنا

    Route::get('/students', [StudentController::class, 'list'])->name('students_list');
    Route::get('/students/delete/{id}', [StudentController::class, 'delete'])->name('students_delete');
    // باقي المسارات


    Route::get('/grades', [GradeController::class, 'list'])->name('grades_list');
    Route::get('/grades/form/{id?}', [GradeController::class, 'form'])->name('grades_form');
    Route::post('/grades/save/{id?}', [GradeController::class, 'save'])->name('grades_save');
    Route::get('/grades/delete/{id}', [GradeController::class, 'delete'])->name('grades_delete');

    Route::get('/questions', [QuestionController::class, 'list'])->name('questions_list');
    Route::get('/questions/form/{id?}', [QuestionController::class, 'form'])->name('questions_form');
    Route::post('/questions/save/{id?}', [QuestionController::class, 'save'])->name('questions_save');
    Route::get('/questions/delete/{id}', [QuestionController::class, 'delete'])->name('questions_delete');
    Route::get('/exam', [QuestionController::class, 'startExam'])->name('exam_start');
    Route::post('/exam/submit', [QuestionController::class, 'submitExam'])->name('exam_submit');
});

Route::get('test', function () {
    return "Test is working!";

    
});