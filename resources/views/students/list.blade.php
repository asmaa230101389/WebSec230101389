<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.menu') <!-- افترضي إن عندك ملف menu مشترك -->
    <div class="container mt-5">
        <h1>Students List</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @can('create-students')
            <a href="{{ route('students_create') }}" class="btn btn-primary mb-3">Add Student</a>
        @endcan
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone ?? 'N/A' }}</td>
                        <td>
                            @can('edit-students')
                                <a href="{{ route('students_edit', $student->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            @endcan
                            @can('delete-students')
                                <a href="{{ route('students_delete', $student->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>