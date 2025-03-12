<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA Simulator</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">GPA Simulator</h1>
        <form method="POST" action="{{ url('/gpa') }}">
            @csrf
            <div id="courses">
                <div class="row mb-3">
                    <div class="col">
                        <input type="number" name="grades[]" class="form-control" placeholder="Grade (0-100)" required>
                    </div>
                    <div class="col">
                        <input type="number" name="hours[]" class="form-control" placeholder="Credit Hours" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addCourse()">Add Course</button>
            <button type="submit" class="btn btn-primary">Calculate GPA</button>
        </form>
        @if(isset($gpa))
            <div class="mt-3">
                <h3>GPA: {{ number_format($gpa, 2) }}</h3>
            </div>
        @endif
    </div>
    <script>
        function addCourse() {
            const container = document.getElementById('courses');
            const row = document.createElement('div');
            row.className = 'row mb-3';
            row.innerHTML = `
                <div class="col">
                    <input type="number" name="grades[]" class="form-control" placeholder="Grade (0-100)" required>
                </div>
                <div class="col">
                    <input type="number" name="hours[]" class="form-control" placeholder="Credit Hours" required>
                </div>
            `;
            container.appendChild(row);
        }
    </script>
</body>
</html>