

<!-- resources/views/minitest.blade.php -->
@extends('layouts.master')

@section('content')
    <h1>MiniTest Page</h1>



<!DOCTYPE html>
<html lang="en">
<head>
    <!-- resources/views/minitest.blade.php -->


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarket Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Supermarket Bill</h3>
            </div>
            <div class="card-body">
                <p><strong>Customer:</strong> {{ $bill['customer'] }}</p>
                <p><strong>Date:</strong> {{ $bill['date'] }}</p>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price </th>
                            <th>Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($bill['items'] as $item)
                            @php $subtotal = $item['quantity'] * $item['price']; $total += $subtotal; @endphp
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>{{ number_format($item['price'], 2) }}</td>
                                <td>{{ number_format($subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Grand Total</th>
                            <th>{{ number_format($total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
@endsection
</html>
