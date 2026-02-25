<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0; }
        body { margin: 0; font-family: 'DejaVu Sans', sans-serif; }
        .page {
            position: relative;
            width: 1400px;
            height: 990px;
            page-break-after: always;
        }
        .bg {
            position: absolute;
            left: 0;
            top: 0;
            width: 1400px;
            height: 990px;
        }
        .name { position: absolute; left: 420px; top: 230px; font-size: 38px; font-weight: 700; color: #111; }
        .course { position: absolute; left: 420px; top: 290px; font-size: 28px; font-weight: 400; color: #222; }
        .number { position: absolute; left: 1100px; top: 520px; font-size: 16px; color: #111; }
        .date { position: absolute; left: 1100px; top: 560px; font-size: 16px; color: #111; }
    </style>
</head>
<body>
@foreach($items as $it)
    <div class="page">
        <img class="bg" src="{{ $bgPath }}">
        <div class="name">{{ $it['name'] }}</div>
        <div class="course">{{ $it['course'] }}</div>
        <div class="number">{{ $it['cert_number'] }}</div>
        <div class="date">{{ $it['issued_at'] }}</div>
    </div>
@endforeach
</body>
</html>
