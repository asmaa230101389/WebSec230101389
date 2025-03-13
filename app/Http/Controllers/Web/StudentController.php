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
        $student = Student::find($id);
        if ($student) {
            $student->delete();
        }
        return redirect('/students');
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect('/students')->with('error', 'Student not found');
        }
        return view('students.edit', compact('student'));
    }
    public function save(Request $request, $id)
{
    $student = Student::find($id);
    if ($student) {
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->save();
    }
    return redirect('/students')->with('success', 'Student updated successfully');
}
}