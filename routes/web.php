<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\GradeController;
use App\Http\Controllers\Web\QuestionController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\CryptoController;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return view('home');
});

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

Route::get('verify', [UserController::class, 'verify'])->name('verify');

Route::get('auth/google', [UserController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [UserController::class, 'handleGoogleCallback']);

// Routes لتسجيل الدخول بفيسبوك
Route::get('auth/facebook', function () {
    return Socialite::driver('facebook')->scopes(['public_profile'])->redirect();
})->name('auth.facebook');

Route::get('callback/facebook', function () {
    try {
        // نجيب الـ access token مباشرة من فيسبوك
        $driver = Socialite::driver('facebook');
        $token = $driver->getAccessTokenResponse(request()->input('code'));

        // نطبع الـ access token عشان نشوف إيه اللي راجع
        dd('Access Token Response: ', $token);

        // نكمّل بجيب بيانات المستخدم
        $facebookUser = $driver->user();

        // نطبع بيانات المستخدم
        dd('Facebook User Data: ', $facebookUser);

        // باقي الكود زي ما هو
        $user = User::where('facebook_id', $facebookUser->id)->first();

        if ($user) {
            Auth::login($user, true);
            session()->regenerate();
            session()->flash('success', 'Logged in successfully with Facebook!');
            return redirect('/home');
        }

        $existingUser = User::where('email', $facebookUser->email)->first();

        if ($existingUser) {
            $existingUser->facebook_id = $facebookUser->id;
            $existingUser->save();

            Auth::login($existingUser, true);
            session()->regenerate();
            session()->flash('success', 'Logged in successfully with Facebook! Your account has been linked.');
            return redirect('/home');
        }

        $newUser = User::create([
            'name' => $facebookUser->name,
            'email' => $facebookUser->email ?? 'facebook_user_' . $facebookUser->id . '@example.com',
            'facebook_id' => $facebookUser->id,
            'password' => bcrypt('dummy-password'),
        ]);

        Auth::login($newUser, true);
        session()->regenerate();
        session()->flash('success', 'Logged in successfully with Facebook!');
        return redirect('/home');
    } catch (\Exception $e) {
        dd('Facebook Login Error: ' . $e->getMessage(), $e->getTraceAsString());
    }
});


Route::get('privacy-policy', function () {
    return "Privacy Policy for WebSecServiceLogin";
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('crypto', [CryptoController::class, 'showForm'])->name('crypto.form');
Route::post('crypto/encrypt', [CryptoController::class, 'encrypt'])->name('crypto.encrypt');
Route::post('crypto/decrypt', [CryptoController::class, 'decrypt'])->name('crypto.decrypt');

Route::get('password/request', [UserController::class, 'showResetRequestForm'])->name('password.request');
Route::post('password/email', [UserController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [UserController::class, 'reset'])->name('password.update');

Route::get('/test', function () {
    return 'Test is working!';
});

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'list'])->name('users_list');
    Route::get('/users/form/{id?}', [UserController::class, 'form'])->name('users_form');
    Route::post('/users/save/{id?}', [UserController::class, 'save'])->name('users_save');
    Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users_delete');

    Route::get('/users/profile', [UserController::class, 'profile'])->name('users.profile');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products/{id}/purchase', [ProductController::class, 'purchase'])->name('products.purchase')->middleware('can:purchase-products');

    Route::middleware(['can:manage-products'])->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    Route::middleware(['can:create-employees'])->group(function () {
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    });

    Route::middleware(['can:view-customers'])->group(function () {
        Route::get('/employees/customers', [EmployeeController::class, 'customers'])->name('employees.customers');
        Route::post('/employees/customers/{id}/add-credit', [EmployeeController::class, 'addCredit'])->name('employees.add-credit')->middleware('can:add-credit');
    });

    Route::get('/purchases', function () {
        $purchases = \App\Models\Purchase::where('user_id', auth()->id())->get();
        return view('purchases.index', compact('purchases'));
    })->name('purchases.index')->middleware('can:view-purchases');

    Route::get('/students', [StudentController::class, 'list'])->name('students_list')->middleware('can:view-students');
    Route::get('/students/delete/{id}', [StudentController::class, 'delete'])->name('students_delete')->middleware('can:delete-students');
    Route::get('/students/edit/{id}', [StudentController::class, 'edit'])->name('students_edit')->middleware('can:edit-students');
    Route::put('/students/save/{id}', [StudentController::class, 'save'])->name('students_save')->middleware('can:edit-students');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students_create')->middleware('can:create-students');
    Route::post('/students', [StudentController::class, 'store'])->name('students_store')->middleware('can:create-students');

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