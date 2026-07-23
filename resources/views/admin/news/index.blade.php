@extends('layouts.app')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#F4F5F7; color:#1A2332; display:flex; align-items:center; justify-content:center; font-size:20px;">📰</span>
                <div>
                    <h2 class="section-title">News Monitoring</h2>
                    <p class="section-subtitle">Monitor global news related to supply chain risk</p>
                </div>
            </div>
            <form action="{{ route('news.generate') }}" method="POST">
                @csrf
                <button class="btn btn-secondary">📡 Generate News</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px;">
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Total News</div>
                <div class="stat-card-value">{{ $totalNews }}</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Today</div>
                <div class="stat-card-value">{{ $todayNews }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Sources</div>
                <div class="stat-card-value">{{ $totalSources }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">Latest Update</div>
                <div class="stat-card-value" style="font-size:16px; margin-top:8px;">{{ $latestDate ? \Carbon\Carbon::parse($latestDate)->format('d M Y') : '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search title, country or source..." class="search-input" style="flex:1;">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th>Country</th>
                        <th>Title</th>
                        <th style="text-align:center;">Source</th>
                        <th style="text-align:center;">Published</th>
                        <th style="text-align:center;">Risk</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($news as $item)
                    @php
                        $title = strtolower($item->title);
                        if(str_contains($title,'flood') || str_contains($title,'earthquake') || str_contains($title,'war') || str_contains($title,'strike')){
                            $risk = 'High';
                        } elseif(str_contains($title,'congestion') || str_contains($title,'delay')){
                            $risk = 'Medium';
                        } else {
                            $risk = 'Low';
                        }
                    @endphp
                    <tr>
                        <td style="text-align:center;">{{ $news->firstItem() + $loop->index }}</td>
                        <td>{{ $item->country->name ?? '-' }}</td>
                        <td style="font-weight:600; max-width:320px;">{{ $item->title }}</td>
                        <td style="text-align:center;"><span class="badge badge-blue">{{ $item->source }}</span></td>
                        <td style="text-align:center;">{{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}</td>
                        <td style="text-align:center;">
                            @if($risk == "High")
                                <span class="badge badge-red">High</span>
                            @elseif($risk == "Medium")
                                <span class="badge badge-amber">Medium</span>
                            @else
                                <span class="badge badge-green">Low</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:40px; color:#8B95A5;">Tidak ada data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $news->links() }}
        </div>
    </div>

</div>

@endsection
