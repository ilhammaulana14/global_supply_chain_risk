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
                <span style="width:40px; height:40px; border-radius:10px; background:#E8F5EF; color:#2D9F6F; display:flex; align-items:center; justify-content:center; font-size:20px;">⚓</span>
                <div>
                    <h2 class="section-title">Port Monitoring</h2>
                    <p class="section-subtitle">Monitor pelabuhan dan tingkat kemacetan logistik.</p>
                </div>
            </div>
            <form action="{{ route('ports.import') }}" method="POST">
                @csrf
                <button class="btn btn-primary">🚢 Import Port Data</button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px;">
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Total Ports</div>
                <div class="stat-card-value">{{ $totalPorts }}</div>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-card-body">
                <div class="stat-card-label">Avg Congestion</div>
                <div class="stat-card-value">{{ $averageCongestion }}%</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Safe Ports</div>
                <div class="stat-card-value">{{ $safePorts }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">Critical Ports</div>
                <div class="stat-card-value">{{ $criticalPorts }}</div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search port, country or code..." class="search-input" style="flex:1;">
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    {{-- Map --}}
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">🌍 Global Port Map</h3>
            <div id="map" style="height:460px; border-radius:10px; overflow:hidden;"></div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div style="overflow-x:auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="text-align:center;">No</th>
                        <th>Port</th>
                        <th>Country</th>
                        <th style="text-align:center;">Code</th>
                        <th style="text-align:center;">Type</th>
                        <th>Congestion</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($ports as $port)
                    <tr>
                        <td style="text-align:center;">{{ $ports->firstItem() + $loop->index }}</td>
                        <td style="font-weight:600;">{{ $port->name }}</td>
                        <td>{{ $port->country->name ?? '-' }}</td>
                        <td style="text-align:center;"><span class="badge badge-blue">{{ $port->code }}</span></td>
                        <td style="text-align:center;">{{ $port->type }}</td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ $port->congestion_level }}%; background:{{ $port->congestion_level < 40 ? '#2D9F6F' : ($port->congestion_level <= 70 ? '#E5A030' : '#E04B4B') }};"></div>
                            </div>
                            <p style="font-size:11px; color:#8B95A5; margin-top:4px;">{{ $port->congestion_level }}%</p>
                        </td>
                        <td style="text-align:center;">
                            @if($port->congestion_level < 40)
                                <span class="badge badge-green">Safe</span>
                            @elseif($port->congestion_level <= 70)
                                <span class="badge badge-amber">Warning</span>
                            @else
                                <span class="badge badge-red">Critical</span>
                            @endif
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
            {{ $ports->links() }}
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const map = L.map('map').setView([20, 0], 2);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

@foreach($mapPorts as $port)
@if($port->latitude && $port->longitude)
L.marker([{{ $port->latitude }}, {{ $port->longitude }}])
    .addTo(map)
    .bindPopup(`<b>{{ $port->name }}</b><br>Country: {{ $port->country->name ?? '-' }}<br>Congestion: {{ $port->congestion_level }}%`);
@endif
@endforeach
</script>
@endpush
