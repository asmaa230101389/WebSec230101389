<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller {
    // List Questions
    public function list() {
        $questions = Question::all();
        return view('questions.list', compact('questions'));
    }

    // Show Create/Edit Form
    public function form($id = null) {
        $question = $id ? Question::findOrFail($id) : null;
        return view('questions.form', compact('question'));
    }

    // Save New/Edit Question
    public function save(Request $request, $id = null) {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $question = $id ? Question::findOrFail($id) : new Question;
        $question->question_text = $request->question_text;
        $question->option_a = $request->option_a;
        $question->option_b = $request->option_b;
        $question->option_c = $request->option_c;
        $question->option_d = $request->option_d;
        $question->correct_answer = $request->correct_answer;
        $question->save();

        return redirect('/questions')->with('success', 'Question saved successfully!');
    }

    // Delete Question
    public function delete($id) {
        $question = Question::find($id);
        if ($question) {
            $question->delete();
        }
        return redirect('/questions')->with('success', 'Question deleted successfully!');
    }

    // Start Exam
    public function startExam() {
        $questions = Question::all();
        if ($questions->isEmpty()) {
            return redirect('/questions')->with('error', 'No questions available to start the exam.');
        }
        return view('questions.exam', compact('questions'));
    }

    // Submit Exam and Show Result
    public function submitExam(Request $request) {
        $answers = $request->input('answers', []);
        $questions = Question::all();
        $score = 0;
        $total = $questions->count();

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            if ($userAnswer === $question->correct_answer) {
                $score++;
            }
        }

        $percentage = $total > 0 ? ($score / $total) * 100 : 0;
        return view('questions.result', compact('score', 'total', 'percentage'));
    }
}