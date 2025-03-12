<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $grade ? 'Edit Grade' : 'Add New Grade' }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">{{ $grade ? 'Edit Grade' : 'Add New Grade' }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ $grade ? route('grades_save', $grade->id) : route('grades_save') }}">
            @csrf
            <div class="mb-3">
                <label>Course Name</label>
                <input type="text" name="course_name" class="form-control" value="{{ old('course_name', $grade->course_name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Credit Hours</label>
                <input type="number" name="credit_hours" class="form-control" value="{{ old('credit_hours', $grade->credit_hours ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Grade (0-100)</label>
                <input type="number" name="grade" class="form-control" value="{{ old('grade', $grade->grade ?? '') }}" step="0.01" required>
            </div>
            <div class="mb-3">
                <label>Term (e.g., Fall 2024)</label>
                <input type="text" name="term" class="form-control" value="{{ old('term', $grade->term ?? '') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('grades_list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>