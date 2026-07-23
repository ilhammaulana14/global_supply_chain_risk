@extends('layouts.app')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">🌍</span>
                <div>
                    <h2 class="section-title">Supply Chain Risk Dashboard</h2>
                    <p class="section-subtitle">Global Supply Chain Risk Intelligence Monitoring</p>
                </div>
            </div>
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <form action="{{ route('weather.refresh') }}" method="POST" onsubmit="return submitButton(this,'Updating...')">
                    @csrf
                    <button type="submit" class="btn btn-primary">🌦 Refresh Weather</button>
                </form>
                <form action="{{ route('economy.import') }}" method="POST" onsubmit="return submitButton(this,'Importing...')">
                    @csrf
                    <button type="submit" class="btn btn-amber">💰 Import Economy</button>
                </form>
                <form action="{{ route('news.generate') }}" method="POST" onsubmit="return submitButton(this,'Generating...')">
                    @csrf
                    <button type="submit" class="btn btn-secondary">📰 Generate News</button>
                </form>
                <form action="{{ route('risk.generate') }}" method="GET" onsubmit="return submitButton(this,'Calculating...')">
                    <button type="submit" class="btn btn-danger">⚠ Generate Risk</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Favorite Monitoring List --}}
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <span style="width:40px; height:40px; border-radius:10px; background:#FEF3D9; color:#E5A030; display:flex; align-items:center; justify-content:center; font-size:20px; font-weight:bold;">⭐</span>
                    <div>
                        <h3 style="font-size:16px; font-weight:800; color:#1A2332;">Favorite Monitoring List</h3>
                        <p style="font-size:11px; color:#8B95A5;">Your pinned priority countries</p>
                    </div>
                </div>
                <a href="{{ route('countries.index') }}" class="btn btn-secondary" style="font-size:12px;">+ Manage</a>
            </div>

            @if(isset($favoriteCountries) && $favoriteCountries->count() > 0)
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
                    @foreach($favoriteCountries as $fav)
                        @php
                            $score = $fav->riskScore->total_score ?? 0;
                            $level = $fav->riskScore->risk_level ?? 'Low';
                            $badgeClass = $level === 'High' ? 'badge-red' : ($level === 'Medium' ? 'badge-amber' : 'badge-green');
                        @endphp
                        <div style="padding:14px; border-radius:10px; background:#F7F8FA; border:1px solid #E8ECF0;">
                            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    @if($fav->flag && filter_var($fav->flag, FILTER_VALIDATE_URL))
                                        <img src="{{ $fav->flag }}" style="width:40px; height:28px; border-radius:4px; object-fit:cover; box-shadow:0 1px 3px rgba(0,0,0,.1);" alt="flag">
                                    @else
                                        <span style="font-size:20px;">🌍</span>
                                    @endif
                                    <div>
                                        <div style="font-size:13px; font-weight:700; color:#1A2332;">{{ $fav->name }}</div>
                                        <div style="font-size:10px; color:#8B95A5; font-weight:600;">{{ $fav->code }}</div>
                                    </div>
                                </div>
                                <form action="{{ route('countries.favorite', $fav->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="background:none; border:none; cursor:pointer; font-size:16px; color:#E5A030;">★</button>
                                </form>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; padding-top:8px; border-top:1px solid #E8ECF0;">
                                <span style="font-size:11px; color:#8B95A5;">Score: <strong style="color:#1A2332;">{{ $score }}</strong></span>
                                <span class="badge {{ $badgeClass }}">{{ $level }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:24px; border:2px dashed #E8ECF0; border-radius:10px;">
                    <p style="font-size:13px; color:#8B95A5; margin-bottom:10px;">No countries added to your favorite list yet.</p>
                    <a href="{{ route('countries.index') }}" class="btn btn-primary" style="font-size:12px;">Browse Countries</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); gap:16px;">
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Countries</div>
                <div class="stat-card-value">{{ $totalCountries }}</div>
            </div>
        </div>
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Weather Data</div>
                <div class="stat-card-value">{{ $totalWeather }}</div>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-card-body">
                <div class="stat-card-label">Ports</div>
                <div class="stat-card-value">{{ $totalPorts }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Economy Data</div>
                <div class="stat-card-value">{{ $totalEconomy }}</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">News</div>
                <div class="stat-card-value">{{ $totalNews }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">High Risk</div>
                <div class="stat-card-value">{{ $highRisk }}</div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">
        <div class="card">
            <div class="card-body">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                    <div>
                        <h3 style="font-size:15px; font-weight:700; color:#1A2332;">📈 Top 10 Highest Risk Countries</h3>
                        <p style="font-size:11px; color:#8B95A5;">Bar chart of countries by risk score</p>
                    </div>
                </div>
                <div style="height:280px;"><canvas id="barChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 style="font-size:15px; font-weight:700; color:#1A2332; margin-bottom:4px;">📊 Risk Distribution</h3>
                <p style="font-size:11px; color:#8B95A5; margin-bottom:16px;">Breakdown by risk level</p>
                <div style="display:flex; justify-content:center; margin-bottom:16px;">
                    <div style="width:180px; height:180px; position:relative;">
                        <canvas id="riskChart"></canvas>
                        <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; pointer-events:none;">
                            <span style="font-size:10px; color:#8B95A5;">Total</span>
                            <span style="font-size:20px; font-weight:900; color:#1A2332;">{{ $highRisk + $mediumRisk + $lowRisk }}</span>
                        </div>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px; font-size:12px;">
                    <div style="display:flex; align-items:center; justify-content:space-between;"><span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:2px; background:#E04B4B;"></span> High</span><strong>{{ $highRisk }}</strong></div>
                    <div style="display:flex; align-items:center; justify-content:space-between;"><span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:2px; background:#E5A030;"></span> Medium</span><strong>{{ $mediumRisk }}</strong></div>
                    <div style="display:flex; align-items:center; justify-content:space-between;"><span style="display:flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:2px; background:#2D9F6F;"></span> Low</span><strong>{{ $lowRisk }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    {{-- World Map --}}
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:15px; font-weight:700; color:#1A2332; margin-bottom:12px;">🌍 Global Supply Chain Risk Map</h3>
            <div id="worldMap" style="height:480px; border-radius:10px; overflow:hidden; border:1px solid #E8ECF0;"></div>
        </div>
    </div>

    {{-- Bottom Tables --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
        <div class="card">
            <div class="card-body">
                <h3 style="font-size:15px; font-weight:700; color:#1A2332; margin-bottom:16px;">🔴 Top 10 Highest Risk</h3>
                <table class="data-table">
                    <thead><tr><th>Country</th><th style="text-align:center;">Score</th><th style="text-align:center;">Risk</th></tr></thead>
                    <tbody>
                    @foreach($topRisk as $risk)
                        <tr>
                            <td style="font-weight:600;">{{ $risk->country->name }}</td>
                            <td style="text-align:center; font-weight:700;">{{ $risk->total_score }}</td>
                            <td style="text-align:center;">
                                @if($risk->risk_level=="High")
                                    <span class="badge badge-red">High</span>
                                @elseif($risk->risk_level=="Medium")
                                    <span class="badge badge-amber">Medium</span>
                                @else
                                    <span class="badge badge-green">Low</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 style="font-size:15px; font-weight:700; color:#1A2332; margin-bottom:16px;">📰 Latest News</h3>
                @forelse($latestNews as $item)
                    <div style="padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <p style="font-size:13px; font-weight:600; color:#1A2332;">{{ $item->title }}</p>
                        <p style="font-size:11px; color:#8B95A5; margin-top:2px;">{{ $item->country->name ?? '-' }}</p>
                    </div>
                @empty
                    <p style="font-size:13px; color:#8B95A5; text-align:center; padding:20px 0;">No news available.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function submitButton(form, text) {
    if(!confirm("Are you sure you want to run this process?")) return false;
    let button = form.querySelector("button");
    button.disabled = true;
    button.innerHTML = "⏳ " + text;
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: [@foreach($topRisk as $risk)"{{ $risk->country->name }}",@endforeach],
            datasets: [{ label: 'Risk Score', data: [@foreach($topRisk as $risk){{ $risk->total_score }},@endforeach], backgroundColor: '#2D9F6F', borderRadius: 4, barThickness: 24 }]
        },
        options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{display:false} }, scales:{ x:{grid:{display:false}, ticks:{font:{size:10}}}, y:{beginAtZero:true, max:100, grid:{color:'#F0F2F5'}, ticks:{font:{size:10}}} } }
    });

    new Chart(document.getElementById('riskChart'), {
        type: 'doughnut',
        data: { labels:['High','Medium','Low'], datasets:[{ data:[{{ $highRisk }},{{ $mediumRisk }},{{ $lowRisk }}], backgroundColor:['#E04B4B','#E5A030','#2D9F6F'], borderWidth:0, hoverOffset:4 }] },
        options: { responsive:true, maintainAspectRatio:false, cutout:'75%', plugins:{legend:{display:false}} }
    });

    const countries = @json($mapCountries);
    const map = L.map('worldMap').setView([20,0],2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{ attribution:'© OpenStreetMap' }).addTo(map);
    countries.forEach(function(country){
        if(country.latitude == null || country.longitude == null) return;
        let color="#2D9F6F", score=0, level="-";
        if(country.risk_score){ score=country.risk_score.total_score; level=country.risk_score.risk_level; if(level==="High") color="#E04B4B"; else if(level==="Medium") color="#E5A030"; }
        L.circleMarker([country.latitude,country.longitude],{ radius:7, color:color, fillColor:color, fillOpacity:0.85 }).addTo(map).bindPopup(`<b>${country.name}</b><br>Risk Score: ${score}<br>Risk Level: ${level}`);
    });
});
</script>
@endpush
