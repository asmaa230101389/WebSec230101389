<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller; // أضيفي السطر ده
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/')->with('success', 'Registered successfully!');
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
    if (!auth()->user()->is_admin) {
        return redirect('/')->with('error', 'You are not authorized to view this page.');
    }
    $users = User::all();
    return view('users.list', compact('users'));
}
public function profile(Request $request)
{
    $user = auth()->user();
    return view('users.profile', compact('user'));
}
}