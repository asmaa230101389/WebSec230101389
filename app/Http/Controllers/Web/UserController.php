<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller; // أضيفي السطر ده
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    
        $user->assignRole('Customer'); // تعيين دور Customer
    
        Auth::login($user);
    
        return redirect('/users/profile');
    }

    
    public function login(Request $request)
    {
        return view('users.login');
    }

    public function doLogin(Request $request)
{
    if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->back()->withErrors(['Invalid login information.']);
    }
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
}