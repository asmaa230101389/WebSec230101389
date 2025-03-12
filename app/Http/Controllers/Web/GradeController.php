<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller {
    // List Grades by Term
    public function list() {
        $terms = Grade::select('term')->distinct()->pluck('term');
        $gradesByTerm = [];
        $gpaByTerm = [];
        $totalCHByTerm = [];
        $cumulativeCH = 0;
        $cumulativePoints = 0;

        foreach ($terms as $term) {
            $grades = Grade::where('term', $term)->get();
            $gradesByTerm[$term] = $grades;
            $totalPoints = $grades->sum(fn($grade) => $grade->grade * $grade->credit_hours);
            $totalCH = $grades->sum('credit_hours');
            $gpaByTerm[$term] = $totalCH > 0 ? $totalPoints / $totalCH : 0;
            $totalCHByTerm[$term] = $totalCH;

            $cumulativeCH += $totalCH;
            $cumulativePoints += $totalPoints;
        }

        $cumulativeCGPA = $cumulativeCH > 0 ? $cumulativePoints / $cumulativeCH : 0;

        return view('grades.list', compact('gradesByTerm', 'gpaByTerm', 'totalCHByTerm', 'cumulativeCGPA', 'cumulativeCH'));
    }

    // Show Create/Edit Form
    public function form($id = null) {
        $grade = $id ? Grade::findOrFail($id) : null;
        return view('grades.form', compact('grade'));
    }

    // Save New/Edit Grade
    public function save(Request $request, $id = null) {
        $request->validate([
            'course_name' => 'required|string|max:256',
            'credit_hours' => 'required|integer|min:1',
            'grade' => 'required|numeric|min:0|max:100',
            'term' => 'required|string|max:50',
        ]);

        $grade = $id ? Grade::findOrFail($id) : new Grade;
        $grade->course_name = $request->course_name;
        $grade->credit_hours = $request->credit_hours;
        $grade->grade = $request->grade;
        $grade->term = $request->term;
        $grade->save();

        return redirect('/grades')->with('success', 'Grade saved successfully!');
    }

    // Delete Grade
    public function delete($id) {
        $grade = Grade::find($id);
        if ($grade) {
            $grade->delete();
        }
        return redirect('/grades')->with('success', 'Grade deleted successfully!');
    }
}