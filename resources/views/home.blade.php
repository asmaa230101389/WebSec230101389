<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <a href="{{ route('products_list') }}" class="btn btn-primary mt-3">View Products</a>
        <a href="{{ url('/minitest') }}" class="btn btn-success mt-3">MiniTest</a>
        <a href="{{ url('/transcript') }}" class="btn btn-info mt-3">Transcript</a>
        <h1 class="mt-5">Welcome to WebSecService</h1>
       
    </div>
    
</body>
</html>