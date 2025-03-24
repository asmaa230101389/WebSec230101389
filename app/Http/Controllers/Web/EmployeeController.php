<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('Employee');

        return redirect('/employees/create')->with('success', 'Employee created successfully');
    }

    public function customers()
    {
        $customers = User::role('Customer')->get();
        return view('employees.customers', compact('customers'));
    }

    public function addCredit(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        $request->validate([
            'credit' => 'required|numeric|min:0',
        ]);

        $customer->credit += $request->credit;
        $customer->save();

        return redirect('/employees/customers')->with('success', 'Credit added successfully');
    }
}