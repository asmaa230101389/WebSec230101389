<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.menu')
    <div class="container mt-5">
        <h1>Products</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @can('manage-products')
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
        @endcan
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th> <!-- التأكد إن العمود ده موجود -->
                    <th>Action</th> <!-- التأكد إن العمود ده موجود -->
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock ?? '0' }}</td> <!-- عرض Stock -->
                        <td>
                            @can('purchase-products')
                                <form action="{{ route('products.purchase', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-success">Buy</button>
                                </form>
                            @endcan
                            @can('manage-products')
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>