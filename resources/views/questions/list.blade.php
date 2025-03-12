<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Questions List</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <a href="{{ route('questions_form') }}" class="btn btn-success mb-3">Add New Question</a>
        <a href="{{ route('exam_start') }}" class="btn btn-primary mb-3">Start Exam</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>{{ strtoupper($question->correct_answer) }}</td>
                        <td>
                            <a href="{{ route('questions_form', $question->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('questions_delete', $question->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>