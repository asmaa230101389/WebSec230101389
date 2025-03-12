<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Simple Calculator</h1>
        <form method="POST" action="{{ url('/calculator') }}">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <input type="number" name="num1" class="form-control" placeholder="Number 1" value="{{ $num1 ?? '' }}" required>
                </div>
                <div class="col">
                    <input type="number" name="num2" class="form-control" placeholder="Number 2" value="{{ $num2 ?? '' }}" required>
                </div>
            </div>
            <div class="mb-3">
                <select name="operation" class="form-select" required>
                    <option value="add" {{ isset($operation) && $operation == 'add' ? 'selected' : '' }}>+</option>
                    <option value="subtract" {{ isset($operation) && $operation == 'subtract' ? 'selected' : '' }}>-</option>
                    <option value="multiply" {{ isset($operation) && $operation == 'multiply' ? 'selected' : '' }}>*</option>
                    <option value="divide" {{ isset($operation) && $operation == 'divide' ? 'selected' : '' }}>/</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Calculate</button>
        </form>
        @if(isset($result))
            <div class="mt-3">
                <h3>Result: {{ $result }}</h3>
            </div>
        @endif
    </div>
</body>
</html>