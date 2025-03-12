<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Exam Result</h1>
        <div class="alert alert-info">
            <p><strong>Score:</strong> {{ $score }} out of {{ $total }}</p>
            <p><strong>Percentage:</strong> {{ number_format($percentage, 2) }}%</p>
        </div>
        <a href="{{ route('exam_start') }}" class="btn btn-primary">Retake Exam</a>
        <a href="{{ route('questions_list') }}" class="btn btn-secondary">Back to Questions</a>
    </div>
</body>
</html>