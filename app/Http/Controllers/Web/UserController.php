<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    // List Users with Filter
    public function list(Request $request) {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
        })->get();
        return view('users.list', compact('users', 'search'));
    }

    // Show Create/Edit Form
    public function form($id = null) {
        $user = $id ? User::findOrFail($id) : null;
        return view('users.form', compact('user'));
    }

    // Save New/Edit User
    public function save(Request $request, $id = null) {
        $request->validate([
            'name' => 'required|string|max:256',
            'email' => 'required|email|max:256|unique:users,email' . ($id ? ",$id" : ''),
            'phone' => 'nullable|string|max:20',
            'password' => ($id ? 'nullable' : 'required') . '|string|min:6',
        ]);
    
        $user = $id ? User::findOrFail($id) : new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
    
        return redirect('/users')->with('success', 'User saved successfully!');
    }

    // Delete User
    public function delete($id) {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect('/users')->with('success', 'User deleted successfully!');
    }
}