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
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle registration request.
     */
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

        // Generate verification link
        $verificationLink = url()->temporarySignedRoute(
            'verify',
            now()->addHours(24),
            ['email' => $user->email, 'token' => Str::random(60)]
        );

        Log::info('Verification link generated', [
            'email' => $user->email,
            'link' => $verificationLink,
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($user, $verificationLink));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
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
            'full_url' => $request->fullUrl(),
        ]);

        // Check if signature is present
        if (!$request->has('signature')) {
            Log::error('No signature provided in verification link', ['email' => $request->query('email')]);
            return redirect()->route('login')->withErrors(['email' => 'Verification link is missing signature.']);
        }

        // Check if the URL signature is valid
        if (!$request->hasValidSignature()) {
            Log::error('Invalid or expired verification link', [
                'email' => $request->query('email'),
                'signature' => $request->query('signature'),
            ]);
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
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request.
     */
    public function doLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->email_verified_at) {
                return back()->withErrors(['email' => 'Your email is not verified. Please check your inbox or spam folder.']);
            }

            Auth::login($user);
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }
}