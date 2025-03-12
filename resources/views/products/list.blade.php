<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        @foreach($products as $product)
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-sm-12 col-lg-4">
                            <img src="{{ asset('images/' . $product->photo) }}" class="img-thumbnail" alt="{{ $product->name }}" width="100%">
                        </div>
                        <div class="col col-sm-12 col-lg-8 mt-3">
                            <h3>{{ $product->name }}</h3>
                            <table class="table table-striped">
                                <tr><th>Name</th><td>{{ $product->name }}</td></tr>
                                <tr><th>Model</th><td>{{ $product->model }}</td></tr>
                                <tr><th>Code</th><td>{{ $product->code }}</td></tr>
                                <tr><th>Description</th><td>{{ $product->description }}</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>