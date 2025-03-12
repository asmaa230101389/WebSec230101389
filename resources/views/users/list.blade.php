<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Users List</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="mb-3">
            <form method="GET" action="{{ route('users_list') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ $search ?? '' }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <a href="{{ route('users_form') }}" class="btn btn-success mb-3">Add New User</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('users_form', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('users_delete', $user->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>