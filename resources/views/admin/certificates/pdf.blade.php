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
        .name { position: absolute; left: {{ isset($posName['x']) ? $posName['x'] : 420 }}px; top: {{ isset($posName['y']) ? $posName['y'] : 230 }}px; font-size: {{ $fontName ?? 38 }}px; font-weight: 700; color: #111; }
        .course { position: absolute; left: {{ isset($posCourse['x']) ? $posCourse['x'] : 420 }}px; top: {{ isset($posCourse['y']) ? $posCourse['y'] : 290 }}px; font-size: {{ $fontCourse ?? 28 }}px; font-weight: 400; color: #222; }
        .number { position: absolute; left: {{ isset($posNumber['x']) ? $posNumber['x'] : 1100 }}px; top: {{ isset($posNumber['y']) ? $posNumber['y'] : 520 }}px; font-size: {{ $fontNumber ?? 16 }}px; color: #111; }
        .date { position: absolute; left: {{ isset($posDate['x']) ? $posDate['x'] : 1100 }}px; top: {{ isset($posDate['y']) ? $posDate['y'] : 560 }}px; font-size: {{ $fontDate ?? 16 }}px; color: #111; }
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
