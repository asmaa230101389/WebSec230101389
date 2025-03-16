<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function list()
    {
        $students = Student::all();
        return view('students.list', compact('students'));
    }

    public function delete($id)
    {
        if (!auth()->user()->hasPermissionTo('delete-students')) {
            return redirect('/students')->with('error', 'You do not have permission to delete students.');
        }
        $student = Student::find($id);
        if ($student) {
            $student->delete();
        }
        return redirect('/students');
    }

    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('edit-students')) {
            return redirect('/students')->with('error', 'You do not have permission to edit students.');
        }
        $student = Student::find($id);
        if (!$student) {
            return redirect('/students')->with('error', 'Student not found');
        }
        return view('students.edit', compact('student'));
    }

    public function save(Request $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('edit-students')) {
            return redirect('/students')->with('error', 'You do not have permission to edit students.');
        }
        $student = Student::find($id);
        if ($student) {
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->save();
        }
        return redirect('/students')->with('success', 'Student updated successfully');
    }

    public function create()
    {
        if (!auth()->user()->hasPermissionTo('create-students')) {
            return redirect('/students')->with('error', 'You do not have permission to create students.');
        }
        return view('students.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('create-students')) {
            return redirect('/students')->with('error', 'You do not have permission to create students.');
        }
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string',
        ]);

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect('/students')->with('success', 'Student created successfully');
    }
}