<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller {
    public function list() {
        $students = Student::all();
        return view('students.list', compact('students'));
    }

    public function delete($id) {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
        }
        return redirect('/students');
    }
}