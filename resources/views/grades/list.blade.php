<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Grades List</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('grades_form') }}" class="btn btn-success mb-3">Add New Grade</a>
        @foreach($gradesByTerm as $term => $grades)
            <h2 class="mt-4">{{ $term }}</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Credit Hours</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->course_name }}</td>
                            <td>{{ $grade->credit_hours }}</td>
                            <td>{{ $grade->grade }}</td>
                            <td>
                                <a href="{{ route('grades_form', $grade->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('grades_delete', $grade->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total CH: {{ $totalCHByTerm[$term] }}</strong> | <strong>GPA: {{ number_format($gpaByTerm[$term], 2) }}</strong></p>
        @endforeach
        <hr>
        <h3>Cumulative Totals</h3>
        <p><strong>Cumulative CH: {{ $cumulativeCH }}</strong> | <strong>CGPA: {{ number_format($cumulativeCGPA, 2) }}</strong></p>
    </div>
</body>
</html>