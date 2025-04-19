<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Mail\VerificationEmail; // تأكدي إن السطر ده موجود وصحيح

class UserController extends Controller
{
    public function register(Request $request)
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Customer');

        $verificationLink = url()->temporarySignedRoute(
            'verify',
            now()->addHours(24),
            ['id' => $user->id]
        );

        Mail::to($user->email)->send(new VerificationEmail($verificationLink, $user->name));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function login(Request $request)
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['Invalid login information.']);
        }

        if (!$user->email_verified_at) {
            return redirect()->back()->withInput($request->input())->withErrors(['Your email is not verified.']);
        }

        Auth::login($user);

        return redirect('/')->with('success', 'Logged in successfully!');
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }

    public function list(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view users')) {
            return redirect('/')->with('error', 'You are not authorized to view this page.');
        }
        $users = User::all();
        return view('users.list', compact('users'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    public function verify(Request $request)
    {
        Log::info('Verify method called with query: ', $request->query());

        if (!$request->hasValidSignature()) {
            Log::error('Invalid or expired signature for verification link: ', $request->query());
            return redirect()->route('login')->withErrors(['The verification link is invalid or has expired.']);
        }

        $userId = $request->query('id');
        Log::info('User ID from query: ' . $userId);

        $user = User::find($userId);

        if (!$user) {
            Log::error('User not found for ID: ' . $userId);
            return redirect()->route('login')->withErrors(['Invalid verification link.']);
        }

        if ($user->email_verified_at) {
            Log::info('Email already verified for user ID: ' . $userId);
            return redirect()->route('login')->with('info', 'Your email is already verified.');
        }

        $user->email_verified_at = now();
        $user->save();

        Log::info('Email verified for user ID: ' . $userId);

        return view('users.verified', ['user' => $user]);
    }
}