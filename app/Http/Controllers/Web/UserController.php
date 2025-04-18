<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\VerificationEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function register(Request $request)
    {
        return view('users.register');
    }

    /**
     * Handle user registration and send verification email.
     */
    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign 'Customer' role
        $user->assignRole('Customer');

        // Generate signed verification link (valid for 24 hours)
        $verificationLink = url()->temporarySignedRoute(
            'verify',
            now()->addHours(24),
            ['email' => $user->email, 'token' => Str::random(60)]
        );

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($verificationLink, $user->name));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    /**
     * Show the login form.
     */
    public function login(Request $request)
    {
        return view('users.login');
    }

    /**
     * Handle user login with email verification check.
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Invalid email or password.']);
        }

        // Check if email is verified
        if (!$user->email_verified_at) {
            return redirect()->back()->withErrors(['email' => 'Your email is not verified. Please check your inbox or spam folder.']);
        }

        // Log user in
        Auth::login($user);

        return redirect('/')->with('success', 'Logged in successfully!');
    }

    /**
     * Handle user logout.
     */
    public function doLogout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully!');
    }

    /**
     * List all users (for authorized users only).
     */
    public function list(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('view users')) {
            return redirect('/')->with('error', 'You are not authorized to view this page.');
        }
        $users = User::all();
        return view('users.list', compact('users'));
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    /**
     * Verify email using signed URL.
     */
    public function verify(Request $request)
    {
        Log::info('Verify request received', [
            'email' => $request->query('email'),
            'token' => $request->query('token'),
            'signature' => $request->query('signature'),
        ]);

        if (!$request->hasValidSignature()) {
            Log::error('Invalid or expired verification link', ['email' => $request->query('email')]);
            return redirect()->route('login')->withErrors(['email' => 'The verification link is invalid or has expired.']);
        }

        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::error('User not found for verification', ['email' => $email]);
            return redirect()->route('login')->withErrors(['email' => 'User not found.']);
        }

        if ($user->email_verified_at) {
            Log::info('Email already verified', ['email' => $email]);
            return redirect()->route('login')->with('info', 'Your email is already verified.');
        }

        $user->email_verified_at = now();
        $user->save();

        Log::info('Email verified successfully', ['email' => $email]);

        return view('users.verified', ['user' => $user]);
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if email is already verified
        if ($user->email_verified_at) {
            return redirect()->back()->with('info', 'Your email is already verified.');
        }

        // Generate new signed verification link
        $verificationLink = url()->temporarySignedRoute(
            'verify',
            now()->addHours(24),
            ['email' => $user->email, 'token' => Str::random(60)]
        );

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($verificationLink, $user->name));

        return redirect()->back()->with('success', 'Verification email resent! Please check your inbox or spam folder.');
    }
}