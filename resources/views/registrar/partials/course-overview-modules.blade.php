<section class="panel">
    <div class="panel-head">
        <h3 class="panel-title">Modules &amp; Topics</h3>
        <button type="button" class="tiny-btn" onclick="toggleAllModules(this)">Expand All</button>
    </div>
    <div class="panel-body">
        @if(!empty($modulesArr))
            <div class="accordion">
                @foreach($modulesArr as $mIndex => $module)
                    @php $topics = (isset($module['topics']) && is_array($module['topics'])) ? $module['topics'] : []; @endphp
                    <div class="acc-item">
                        <div class="acc-header" onclick="toggleAccBody(this)">
                            <div class="acc-left">
                                <div class="acc-num">{{ $mIndex + 1 }}</div>
                                <div class="acc-name">Module {{ $mIndex + 1 }}: {{ $module['title'] ?? '' }}</div>
                            </div>
                            <div class="acc-right">
                                <span class="pill">{{ count($topics) }} {{ count($topics) === 1 ? 'Topic' : 'Topics' }}</span>
                                <i class="fas fa-chevron-down" style="color:#94a3b8;transition:transform .18s ease"></i>
                            </div>
                        </div>
                        <div class="acc-body">
                            @forelse($topics as $tIndex => $topic)
                                <div class="topic">
                                    <span>{{ ($mIndex + 1) . '.' . ($tIndex + 1) }}</span>
                                    <span>{{ $topic['title'] ?? 'Untitled topic' }}</span>
                                </div>
                            @empty
                                <div class="topic"><span>-</span><span>No topics</span></div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty">No modules added yet.</div>
        @endif
    </div>
</section>


