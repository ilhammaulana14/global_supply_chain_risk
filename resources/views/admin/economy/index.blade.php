@extends('layouts.app')

@section('content')

@php
function shortNumber($number) {
    if ($number >= 1000000000000) return number_format($number / 1000000000000, 2) . ' T';
    if ($number >= 1000000000)    return number_format($number / 1000000000, 2) . ' B';
    if ($number >= 1000000)       return number_format($number / 1000000, 2) . ' M';
    return number_format($number, 2);
}
@endphp

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">
            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#FEF3D9; color:#E5A030; display:flex; align-items:center; justify-content:center; font-size:20px;">💰</span>
                <div>
                    <h2 class="section-title">Economy Monitoring</h2>
                    <p class="section-subtitle">Monitor indikator ekonomi setiap negara</p>
                </div>
            </div>
            <form action="{{ route('economy.import') }}" method="POST">
                @csrf
                <button class="btn btn-amber">📥 Import Data</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px;">
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Countries</div>
                <div class="stat-card-value">{{ $totalCountries }}</div>
            </div>
        </div>
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Average GDP</div>
                <div class="stat-card-value" style="font-size:22px;">{{ shortNumber($averageGDP) }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">Avg Inflation</div>
                <div class="stat-card-value">{{ $averageInflation }}%</div>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-card-body">
                <div class="stat-card-label">Avg Export</div>
                <div class="stat-card-value" style="font-size:22px;">{{ shortNumber($averageExports) }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Avg Import</div>
                <div class="stat-card-value" style="font-size:22px;">{{ shortNumber($averageImports) }}</div>
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
                        <th style="text-align:center;">Year</th>
                        <th style="text-align:center;">GDP</th>
                        <th>Inflation</th>
                        <th style="text-align:center;">Export</th>
                        <th style="text-align:center;">Import</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($economies as $economy)
                    <tr>
                        <td style="text-align:center;">{{ $economies->firstItem() + $loop->index }}</td>
                        <td style="font-weight:600;">{{ $economy->country->name }}</td>
                        <td style="text-align:center;"><span class="badge badge-blue">{{ $economy->year }}</span></td>
                        <td style="text-align:center; font-weight:700; color:#2D9F6F;">{{ shortNumber($economy->gdp) }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill bg-red-500" style="width:{{ min($economy->inflation * 7, 100) }}%; background:#E04B4B;"></div>
                            </div>
                            <p style="font-size:11px; color:#8B95A5; margin-top:4px;">{{ $economy->inflation }}%</p>
                        </td>
                        <td style="text-align:center; font-weight:600; color:#2563EB;">{{ shortNumber($economy->exports) }}</td>
                        <td style="text-align:center; font-weight:600; color:#E5A030;">{{ shortNumber($economy->imports) }}</td>
                        <td style="text-align:center;">
                            @if($economy->inflation < 3)
                                <span class="badge badge-green">🟢 Stable</span>
                            @elseif($economy->inflation <= 6)
                                <span class="badge badge-amber">🟡 Moderate</span>
                            @else
                                <span class="badge badge-red">🔴 High</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; padding:40px; color:#8B95A5;">Tidak ada data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $economies->links() }}
        </div>
    </div>

</div>

@endsection
