@extends('layouts.master')

@section('title', 'Student Transcript')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Student Transcript</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student['name'] }}</p>
            <p><strong>Student ID:</strong> {{ $student['id'] }}</p>
            <p><strong>Major:</strong> {{ $student['major'] }}</p>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Course</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student['courses'] as $course)
                        <tr>
                            <td>{{ $course['name'] }}</td>
                            <td>{{ $course['grade'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
