@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Cryptography Basics</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif
    @if (isset($result))
        <div class="alert alert-info">
            <strong>{{ ucfirst($operation) }}ed Result:</strong> {{ $result }}
        </div>
    @endif
    <form method="POST" action="{{ route('crypto.encrypt') }}">
        @csrf
        <div class="form-group">
            <label for="text">Enter Text:</label>
            <textarea name="text" class="form-control" rows="4" required>{{ old('text') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <form method="POST" action="{{ route('crypto.decrypt') }}">
        @csrf
        <div class="form-group">
            <label for="text">Enter Encrypted Text:</label>
            <textarea name="text" class="form-control" rows="4" required>{{ old('text') }}</textarea>
        </div>
        <button type="submit" class="btn btn-secondary">Decrypt</button>
    </form>
</div>
@endsection