<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user ? 'Edit User' : 'Add New User' }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">{{ $user ? 'Edit User' : 'Add New User' }}</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ $user ? route('users_save', $user->id) : route('users_save') }}">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" {{ $user ? '' : 'required' }}>
                @if($user)
                    <small class="form-text text-muted">Leave blank to keep current password.</small>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('users_list') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>