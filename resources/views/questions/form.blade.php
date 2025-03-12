<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $question ? 'Edit Question' : 'Add New Question' }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">{{ $question ? 'Edit Question' : 'Add New Question' }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ $question ? route('questions_save', $question->id) : route('questions_save') }}">
            @csrf
            <div class="mb-3">
                <label>Question Text</label>
                <textarea name="question_text" class="form-control" required>{{ old('question_text', $question->question_text ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label>Option A</label>
                <input type="text" name="option_a" class="form-control" value="{{ old('option_a', $question->option_a ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Option B</label>
                <input type="text" name="option_b" class="form-control" value="{{ old('option_b', $question->option_b ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Option C</label>
                <input type="text" name="option_c" class="form-control" value="{{ old('option_c', $question->option_c ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Option D</label>
                <input type="text" name="option_d" class="form-control" value="{{ old('option_d', $question->option_d ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Correct Answer</label>
                <select name="correct_answer" class="form-control" required>
                    <option value="a" {{ old('correct_answer', $question->correct_answer ?? '') == 'a' ? 'selected' : '' }}>A</option>
                    <option value="b" {{ old('correct_answer', $question->correct_answer ?? '') == 'b' ? 'selected' : '' }}>B</option>
                    <option value="c" {{ old('correct_answer', $question->correct_answer ?? '') == 'c' ? 'selected' : '' }}>C</option>
                    <option value="d" {{ old('correct_answer', $question->correct_answer ?? '') == 'd' ? 'selected' : '' }}>D</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('questions_list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>