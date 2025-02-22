<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Even Numbers</title>
    <!-- استيراد Bootstrap -->
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

    <div class="card">
        <div class="card-header">
            <h4>Even Numbers</h4>
        </div>
        <div class="card-body">
            @foreach (range(1, 100) as $i)
                @if($i % 2 == 0)
                    <span class="badge bg-primary">{{ $i }}</span>
                @else
                    <span class="badge bg-secondary">{{ $i }}</span>
                @endif
            @endforeach
        </div>
    </div>

</body>
</html>
