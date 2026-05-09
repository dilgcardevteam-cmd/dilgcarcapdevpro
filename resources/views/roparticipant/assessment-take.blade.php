<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $assessment->title }} · Assessment</title>
    <link href="{{ asset('css/dm-sans.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root{--blue:#002C76;--muted:#6b7280;--border:#e5e7eb;--ring:#60a5fa;--bg:#f4f6f9}
        body{margin:0;background:var(--bg);font-family:'DM Sans',sans-serif;color:#111827}
        .wrap{max-width:980px;margin:24px auto;padding:0 16px}
        .card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:16px;box-shadow:0 10px 24px rgba(15,23,42,.06)}
        .title{margin:0 0 8px;font-weight:800;color:var(--blue);letter-spacing:-0.01em}
        .muted{color:#64748b}
        .question{border:1px solid var(--border);border-radius:14px;padding:16px;margin:12px 0;background:#fff}
        .q-title{font-weight:800;margin:0 0 10px;display:flex;align-items:center;justify-content:space-between;gap:10px}
        .q-title-text{flex:1;min-width:0}
        .qtype-pill{flex:0 0 auto;font-size:.72rem;font-weight:900;text-transform:uppercase;letter-spacing:.08em;padding:6px 10px;border-radius:999px;background:#f1f5f9;border:1px solid #e2e8f0;color:#334155;white-space:nowrap}
        .opt{display:flex;align-items:center;gap:10px;padding:10px;border:1px solid var(--border);border-radius:12px;margin:6px 0;background:#f8fafc;cursor:pointer}
        .opt:hover{background:#eef2ff}
        .opt input{width:18px;height:18px}
        .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:8px}
        .btn{border:none;border-radius:12px;padding:12px 16px;font-weight:700;cursor:pointer}
        .btn-blue{background:#0f3b8f;color:#fff}
        .btn-ghost{background:#fff;border:1px solid var(--border);color:#0f172a}
        .result{margin-top:10px;font-weight:700}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h1 class="title">{{ $assessment->title }}</h1>
            <div class="muted">{{ $assessment->description }}</div>
            <form id="takeForm" method="POST" action="{{ route('trainee.assessments.submit', $assessment) }}">
                @csrf
                @foreach($questions as $qi => $q)
                    <div class="question" data-qi="{{ $qi }}">
                        @php
                          $qt = (string) ($q['type'] ?? '');
                          $typeLabel = match ($qt) {
                            'multiple_choice_multiple' => 'Multiple Choice (Multiple Answers)',
                            'multiple_choice_single', 'multiple_choice' => 'Multiple Choice (Single Answer)',
                            'true_false' => 'True/False',
                            'identification' => 'Identification',
                            'enumeration' => 'Enumeration',
                            'essay' => 'Essay',
                            default => $qt !== '' ? ucwords(str_replace('_', ' ', $qt)) : 'Question',
                          };
                        @endphp
                        <div class="q-title">
                          <span class="q-title-text">{{ $q['title'] ?? ('Question '.($qi+1)) }}</span>
                          <span class="qtype-pill">{{ $typeLabel }}</span>
                        </div>
                        @php $opts = $q['options'] ?? []; @endphp
                        @foreach($opts as $oi => $o)
                            <label class="opt">
                                <input type="radio" name="answers[{{ $qi }}]" value="{{ $oi }}">
                                <span>{{ $o }}</span>
                            </label>
                        @endforeach
                    </div>
                @endforeach
                <div class="actions">
                    <a class="btn btn-ghost" href="{{ url()->previous() }}"><i class="fas fa-arrow-left"></i> Cancel</a>
                    <button class="btn btn-blue" type="submit"><i class="fas fa-paper-plane"></i> Submit Answers</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
