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
                <span style="width:40px; height:40px; border-radius:10px; background:#FDECEC; color:#E04B4B; display:flex; align-items:center; justify-content:center; font-size:20px;">📊</span>
                <div>
                    <h2 class="section-title">Supply Chain Risk Score</h2>
                    <p class="section-subtitle">Overall supply chain risk analysis for each country</p>
                </div>
            </div>
            <a href="{{ route('risk.generate') }}" class="btn btn-danger">⚡ Generate Risk</a>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px;">
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Countries</div>
                <div class="stat-card-value">{{ $totalCountries }}</div>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-card-body">
                <div class="stat-card-label">Average Risk</div>
                <div class="stat-card-value">{{ $averageRisk }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">High Risk</div>
                <div class="stat-card-value">{{ $highRisk }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Medium Risk</div>
                <div class="stat-card-value">{{ $mediumRisk }}</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Low Risk</div>
                <div class="stat-card-value">{{ $lowRisk }}</div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search Country..." class="search-input" style="flex:1;">
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
                        <th style="text-align:center;">Weather</th>
                        <th style="text-align:center;">Port</th>
                        <th style="text-align:center;">Economy</th>
                        <th style="text-align:center;">News</th>
                        <th>Total Score</th>
                        <th style="text-align:center;">Risk Level</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($scores as $score)
                    <tr>
                        <td style="text-align:center;">{{ $scores->firstItem() + $loop->index }}</td>
                        <td style="font-weight:600;">{{ $score->country->name }}</td>
                        <td style="text-align:center;">{{ $score->weather_score }}</td>
                        <td style="text-align:center;">{{ $score->port_score }}</td>
                        <td style="text-align:center;">{{ $score->economy_score }}</td>
                        <td style="text-align:center;">{{ $score->news_score }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ $score->total_score }}%; background:{{ $score->total_score < 40 ? '#2D9F6F' : ($score->total_score < 70 ? '#E5A030' : '#E04B4B') }};"></div>
                            </div>
                            <p style="font-size:11px; color:#8B95A5; margin-top:4px;">{{ $score->total_score }}/100</p>
                        </td>
                        <td style="text-align:center;">
                            @if($score->risk_level == 'Low')
                                <span class="badge badge-green">🟢 Low</span>
                            @elseif($score->risk_level == 'Medium')
                                <span class="badge badge-amber">🟡 Medium</span>
                            @else
                                <span class="badge badge-red">🔴 High</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:#8B95A5;">No Risk Score Found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $scores->links() }}
        </div>
    </div>

</div>

@endsection
