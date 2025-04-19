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
use App\Mail\VerificationEmail;
use App\Mail\ResetPasswordEmail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\DB;

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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now(),
                    'password' => Hash::make(Str::random(16)),
                ]);
                $user->assignRole('Customer');
            }

            Auth::login($user);

            return redirect('/')->with('success', 'Logged in with Google successfully!');
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['Google login failed. Please try again.']);
        }
    }

    public function showResetRequestForm()
    {
        return view('users.password_request');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => now()]
        );

        $resetLink = url()->temporarySignedRoute(
            'password.reset',
            now()->addHours(1),
            ['token' => $token, 'email' => $user->email]
        );

        Mail::to($user->email)->send(new ResetPasswordEmail($resetLink, $user->name));

        return back()->with('success', 'We have emailed your password reset link!');
    }

    public function showResetForm(Request $request, $token)
    {
        return view('users.password_reset', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset!');
    }
}