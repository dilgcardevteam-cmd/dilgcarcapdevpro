<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <title>Certificate Preview</title>
    <style>
        body { margin:0; background:#f3f4f6; font-family: 'DM Sans', sans-serif; }
        .wrap { max-width: 1400px; margin: 20px auto; background:#fff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; }
        .canvas {
            position: relative;
            width: 1400px;
            height: 990px;
            background: url("{{ $bgUrl }}") no-repeat left top/cover;
        }
        .name { position: absolute; left: 420px; top: 230px; font-size: 38px; font-weight: 800; color: #111; }
        .course { position: absolute; left: 420px; top: 290px; font-size: 28px; font-weight: 500; color: #222; }
        .number { position: absolute; left: 1100px; top: 520px; font-size: 16px; color: #111; }
        .date { position: absolute; left: 1100px; top: 560px; font-size: 16px; color: #111; }
        .bar { padding:12px 16px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e5e7eb; }
        .bar a { text-decoration:none; }
        .btn { padding:8px 12px; border:none; border-radius:8px; cursor:pointer; }
        .btn-primary { background:#0f3b8f; color:#fff; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="bar">
            <div style="font-weight:800;color:#0f3b8f">Certificate Preview</div>
            <div>
                <a href="javascript:history.back()" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="canvas">
            <div class="name">{{ $name }}</div>
            <div class="course">{{ $course }}</div>
            <div class="number">{{ $cert_number }}</div>
            <div class="date">{{ $issued_at }}</div>
        </div>
    </div>
</body>
</html>



