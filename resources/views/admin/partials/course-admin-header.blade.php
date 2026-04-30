@php
    $headerLinks = $headerLinks ?? [];
@endphp
<header class="header" style="background:#fff; height:80px; display:flex; align-items:center; justify-content:space-between; padding:0 24px; box-shadow:0 2px 4px rgba(0,0,0,0.05); position:sticky; top:0; z-index:100;">
    <div class="header-left" style="display:flex; align-items:center; gap:12px;">
        <div class="header-title">
            <img src="{{ asset('images/CAPDEV-PRO-LOGO.png') }}" alt="CapDev Pro" style="height:40px; display:block;">
        </div>
    </div>
    <div class="header-right" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap; justify-content:flex-end;">
        @foreach($headerLinks as $link)
            @if(($link['visible'] ?? true) && !empty($link['href']) && !empty($link['label']))
                @php
                    $variant = $link['variant'] ?? 'primary';
                    $isPrimary = $variant === 'primary';
                    $bg = $isPrimary ? '#002C76' : '#f8fafc';
                    $color = $isPrimary ? '#ffffff' : '#002C76';
                    $border = $isPrimary ? '#002C76' : '#002C76';
                @endphp
                <a
                    href="{{ $link['href'] }}"
                    class="back-link"
                    style="margin:0; background-color: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $border }}; padding: 8px 16px; border-radius: 5px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px;"
                >
                    @if(!empty($link['icon']))
                        <i class="{{ $link['icon'] }}"></i>
                    @endif
                    <span>{{ $link['label'] }}</span>
                </a>
            @endif
        @endforeach
    </div>
</header>
