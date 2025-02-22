<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Numbers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            width: 50%;
            margin: 20px auto;
            text-align: center;
        }
        .badge {
            font-size: 18px;
            margin: 5px;
            padding: 10px;
        }
    </style>
</head>
<body>

    <?php
    function isPrime($number) {
        if ($number < 2) return false;
        for ($i = 2; $i <= sqrt($number); $i++) {
            if ($number % $i == 0) return false;
        }
        return true;
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h4>Prime Numbers</h4>
        </div>
        <div class="card-body">
            @foreach (range(1, 100) as $i)
                @if(isPrime($i))
                    <span class="badge bg-success">{{ $i }}</span>
                @else
                    <span class="badge bg-secondary">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>

</body>
</html>
