<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCQ Exam</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">MCQ Exam</h1>
        <form method="POST" action="{{ route('exam_submit') }}">
            @csrf
            @foreach($questions as $index => $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Question {{ $index + 1 }}: {{ $question->question_text }}</h5>
                        <div class="form-check">
                            <input type="radio" name="answers[{{ $question->id }}]" value="a" class="form-check-input" required>
                            <label class="form-check-label">A) {{ $question->option_a }}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="answers[{{ $question->id }}]" value="b" class="form-check-input">
                            <label class="form-check-label">B) {{ $question->option_b }}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="answers[{{ $question->id }}]" value="c" class="form-check-input">
                            <label class="form-check-label">C) {{ $question->option_c }}</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="answers[{{ $question->id }}]" value="d" class="form-check-input">
                            <label class="form-check-label">D) {{ $question->option_d }}</label>
                        </div>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Submit Exam</button>
        </form>
    </div>
</body>
</html>