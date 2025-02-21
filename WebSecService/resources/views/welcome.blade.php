<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        <div class="card m-4">
            <div class="card-body">Welcome to Laravel WebSec Service</div>
        </div>
    </div>
</body>
</html>
