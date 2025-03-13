<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        <h1 class="mt-5">Login</h1>
        <form action="{{ route('do_login') }}" method="post">
            @csrf
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ $error }}
                </div>
            @endforeach
            <div class="form-group mb-2">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" placeholder="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group mb-2">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" placeholder="password" name="password" required>
            </div>
            <div class="form-group mb-2">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>
</html>