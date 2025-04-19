@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Login</h2>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('do_login') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Password?</a>
    </form>
    <hr>
    <a href="{{ route('auth.google') }}" class="btn btn-danger">Login with Google</a>
</div>
@endsection