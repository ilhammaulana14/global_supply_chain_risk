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
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">🌤</span>
                <div>
                    <h2 class="section-title">Weather Monitoring</h2>
                    <p class="section-subtitle">Monitor cuaca seluruh negara secara realtime</p>
                </div>
            </div>
            <form action="{{ route('weather.refresh') }}" method="POST">
                @csrf
                <button class="btn btn-primary">🔄 Refresh All</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px;">
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Countries</div>
                <div class="stat-card-value">{{ $totalCountry }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">Average Temp</div>
                <div class="stat-card-value">{{ $avgTemp }}°C</div>
            </div>
        </div>
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Average Rain</div>
                <div class="stat-card-value">{{ $avgRain }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Highest Temp</div>
                <div class="stat-card-value">{{ $highestTemp }}°C</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">Storm Risk Countries</div>
                <div class="stat-card-value">{{ $stormCount }}</div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search country..." class="search-input" style="flex:1;">
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
                        <th style="text-align:center;">Temperature</th>
                        <th style="text-align:center;">Rainfall</th>
                        <th style="text-align:center;">Wind</th>
                        <th style="text-align:center;">Storm</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td style="text-align:center;">{{ $countries->firstItem() + $loop->index }}</td>
                        <td style="font-weight:600;">{{ $country->name }}</td>
                        <td style="text-align:center;">
                            @if($country->weatherLog)
                                @php $temp = $country->weatherLog->temperature; @endphp
                                @if($temp >= 35)
                                    <span class="badge badge-red">{{ $temp }}°C</span>
                                @elseif($temp >= 25)
                                    <span class="badge badge-amber">{{ $temp }}°C</span>
                                @else
                                    <span class="badge badge-blue">{{ $temp }}°C</span>
                                @endif
                            @else
                                <span style="color:#8B95A5;">-</span>
                            @endif
                        </td>
                        <td style="text-align:center;">{{ $country->weatherLog->rainfall ?? '-' }}</td>
                        <td style="text-align:center;">{{ $country->weatherLog->wind_speed ?? '-' }}</td>
                        <td style="text-align:center;">
                            @if(!$country->weatherLog)
                                <span style="color:#8B95A5;">-</span>
                            @elseif($country->weatherLog->storm_risk == 3)
                                <span class="badge badge-red">High</span>
                            @elseif($country->weatherLog->storm_risk == 2)
                                <span class="badge badge-amber">Medium</span>
                            @elseif($country->weatherLog->storm_risk == 1)
                                <span class="badge badge-green">Low</span>
                            @else
                                <span class="badge" style="background:#F4F5F7; color:#8B95A5;">None</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            <form action="{{ route('weather.update', $country->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-primary" style="padding:6px 14px; font-size:12px;">Refresh</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#8B95A5;">Tidak ada data.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $countries->links() }}
        </div>
    </div>

</div>

@endsection
