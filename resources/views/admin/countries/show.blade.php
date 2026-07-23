@extends('layouts.app')

@section('content')

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px;">
    <div style="display:flex; align-items:center; gap:16px;">
        <img src="{{ $country->flag }}" alt="{{ $country->name }}" style="width:80px; height:54px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.1); object-fit:cover;">
        <div>
            <h1 class="section-title">{{ $country->name }}</h1>
            <p class="section-subtitle">Supply Chain Risk Intelligence</p>
            @if($country->riskScore)
                @php $color = match($country->riskScore->risk_level){ 'High' => 'badge-red', 'Medium' => 'badge-amber', default => 'badge-green' }; @endphp
                <span class="badge {{ $color }}" style="margin-top:6px;">{{ strtoupper($country->riskScore->risk_level) }} RISK</span>
            @endif
        </div>
    </div>
    <div style="display:flex; gap:8px;">
        <form action="{{ route('countries.favorite', $country->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn {{ $country->isFavoritedBy(auth()->user()) ? 'btn-amber' : 'btn-secondary' }}">
                {{ $country->isFavoritedBy(auth()->user()) ? '★ Favorited' : '☆ Favorite' }}
            </button>
        </form>
        <a href="{{ route('countries.index') }}" class="btn btn-secondary">← Back</a>
    </div>
</div>

{{-- Country Information --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:20px;">🌍 Country Information</h2>
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:20px;">
            @foreach([['Country', $country->name], ['Code', $country->code], ['Capital', $country->capital ?? '-'], ['Region', $country->region ?? '-'], ['Population', number_format($country->population)], ['Currency', $country->currency ?? '-']] as [$label, $val])
                <div><p style="font-size:11px; color:#8B95A5; font-weight:600; text-transform:uppercase; letter-spacing:.5px;">{{ $label }}</p><h3 style="font-size:16px; font-weight:700; color:#1A2332; margin-top:4px;">{{ $val }}</h3></div>
            @endforeach
        </div>
    </div>
</div>

{{-- Weather & Economy --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
    {{-- Weather --}}
    <div class="card">
        <div class="card-body">
            <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">🌤 Weather Information</h2>
            @if($country->weatherLog)
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="display:flex; justify-content:space-between; padding-bottom:10px; border-bottom:1px solid #F0F2F5;"><span style="color:#8B95A5; font-size:13px;">Temperature</span><span style="font-weight:700; font-size:16px;">{{ $country->weatherLog->temperature }} °C</span></div>
                    <div style="display:flex; justify-content:space-between; padding-bottom:10px; border-bottom:1px solid #F0F2F5;"><span style="color:#8B95A5; font-size:13px;">Rainfall</span><span style="font-weight:700; font-size:16px;">{{ $country->weatherLog->rainfall }} mm</span></div>
                    <div style="display:flex; justify-content:space-between;"><span style="color:#8B95A5; font-size:13px;">Storm Risk</span>
                        @if($country->weatherLog->storm_risk >= 3)<span class="badge badge-red">High</span>
                        @elseif($country->weatherLog->storm_risk == 2)<span class="badge badge-amber">Medium</span>
                        @else<span class="badge badge-green">Low</span>@endif
                    </div>
                </div>
            @else
                <p style="color:#8B95A5; font-size:13px;">No weather information available.</p>
            @endif
        </div>
    </div>

    {{-- Economy --}}
    <div class="card">
        <div class="card-body">
            <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">💰 Economy</h2>
            @if($country->economicData)
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <div style="display:flex; justify-content:space-between; padding-bottom:10px; border-bottom:1px solid #F0F2F5;"><span style="color:#8B95A5; font-size:13px;">GDP</span><span style="font-weight:700;">${{ number_format($country->economicData->gdp,2) }}</span></div>
                    <div style="display:flex; justify-content:space-between; padding-bottom:10px; border-bottom:1px solid #F0F2F5;"><span style="color:#8B95A5; font-size:13px;">Inflation</span><span style="font-weight:700;">{{ $country->economicData->inflation }} %</span></div>
                    <div style="display:flex; justify-content:space-between; padding-bottom:10px; border-bottom:1px solid #F0F2F5;"><span style="color:#8B95A5; font-size:13px;">Exports</span><span style="font-weight:700;">${{ number_format($country->economicData->exports,2) }}</span></div>
                    <div style="display:flex; justify-content:space-between;"><span style="color:#8B95A5; font-size:13px;">Imports</span><span style="font-weight:700;">${{ number_format($country->economicData->imports,2) }}</span></div>
                </div>
            @else
                <p style="color:#8B95A5; font-size:13px;">No economy information available.</p>
            @endif
        </div>
    </div>
</div>

{{-- Ports --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">🚢 Ports</h2>
        <table class="data-table">
            <thead><tr><th>Port Name</th><th style="text-align:center;">Congestion</th></tr></thead>
            <tbody>
            @forelse($country->ports as $port)
                <tr>
                    <td style="font-weight:600;">{{ $port->name }}</td>
                    <td style="text-align:center;">
                        @if($port->congestion_level >= 70)<span class="badge badge-red">{{ $port->congestion_level }}%</span>
                        @elseif($port->congestion_level >= 40)<span class="badge badge-amber">{{ $port->congestion_level }}%</span>
                        @else<span class="badge badge-green">{{ $port->congestion_level }}%</span>@endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" style="text-align:center; padding:30px; color:#8B95A5;">No port data available.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Latest News --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">📰 Latest News</h2>
        @forelse($country->news->take(5) as $item)
            <div style="padding:12px 0; border-bottom:1px solid #F0F2F5; display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <h4 style="font-size:14px; font-weight:600; color:#1A2332;">{{ $item->title }}</h4>
                    <p style="font-size:11px; color:#8B95A5; margin-top:2px;">{{ $item->source }} • {{ optional($item->published_at)->format('d M Y') }}</p>
                </div>
                @if($item->url)<a href="{{ $item->url }}" target="_blank" class="btn btn-secondary" style="padding:4px 12px; font-size:11px;">Read</a>@endif
            </div>
        @empty
            <div style="text-align:center; padding:30px; color:#8B95A5; font-size:13px;">No news available.</div>
        @endforelse
    </div>
</div>

{{-- Risk Score --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <h2 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:20px;">⚠ Supply Chain Risk Assessment</h2>
        @if($country->riskScore)
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:12px; margin-bottom:24px;">
                @foreach([['Weather Score', $country->riskScore->weather_score, 'blue'], ['Port Score', $country->riskScore->port_score, 'indigo'], ['Economy Score', $country->riskScore->economy_score, 'green'], ['News Score', $country->riskScore->news_score, 'amber'], ['Total Score', $country->riskScore->total_score, 'red']] as [$label, $val, $c])
                    <div class="stat-card {{ $c }}"><div class="stat-card-body"><div class="stat-card-label">{{ $label }}</div><div class="stat-card-value">{{ $val }}</div></div></div>
                @endforeach
                <div class="stat-card {{ $country->riskScore->risk_level == 'High' ? 'red' : ($country->riskScore->risk_level == 'Medium' ? 'amber' : 'green') }}">
                    <div class="stat-card-body">
                        <div class="stat-card-label">Risk Level</div>
                        <div style="margin-top:8px;"><span class="badge {{ $country->riskScore->risk_level == 'High' ? 'badge-red' : ($country->riskScore->risk_level == 'Medium' ? 'badge-amber' : 'badge-green') }}" style="font-size:14px; padding:6px 16px;">{{ strtoupper($country->riskScore->risk_level) }}</span></div>
                    </div>
                </div>
            </div>
            {{-- Progress Bar --}}
            <div style="margin-top:16px;">
                <div style="display:flex; justify-content:space-between; margin-bottom:6px;"><span style="font-size:13px; font-weight:600;">Overall Risk Score</span><span style="font-weight:700;">{{ $country->riskScore->total_score }}/100</span></div>
                <div class="progress-bar" style="height:12px;">
                    <div class="progress-fill" style="width:{{ $country->riskScore->total_score }}%; background:{{ $country->riskScore->risk_level=='High' ? '#E04B4B' : ($country->riskScore->risk_level=='Medium' ? '#E5A030' : '#2D9F6F') }};"></div>
                </div>
            </div>
        @else
            <div style="text-align:center; padding:40px; color:#8B95A5;">Risk score not generated.</div>
        @endif
    </div>
</div>

</div>

@endsection
