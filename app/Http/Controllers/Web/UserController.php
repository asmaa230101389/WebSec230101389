<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            ['email' => $user->email, 'token' => Str::random(60)]
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
            return redirect()->back()->withErrors(['Your email is not verified. Please check your inbox or spam folder.']);
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
        if (!$request->hasValidSignature()) {
            return redirect()->route('login')->withErrors(['The verification link is invalid or has expired.']);
        }

        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['User not found.']);
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Your email is already verified.');
        }

        $user->email_verified_at = now();
        $user->save();

        return view('users.verified', ['user' => $user]);
    }
}