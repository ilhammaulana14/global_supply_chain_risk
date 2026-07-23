@extends('layouts.app')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header Card --}}
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">🌍</span>
                <div>
                    <h2 class="section-title">Country Comparison Engine</h2>
                    <p class="section-subtitle">Compare countries based on demographic, economic, weather and supply chain risk indicators.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Selection Form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('comparison.compare') }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:16px; align-items:end;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Country 1</label>
                        <select name="country1" class="search-input" style="width:100%;">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ isset($country1) && $country1->id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Country 2</label>
                        <select name="country2" class="search-input" style="width:100%;">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ isset($country2) && $country2->id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">⚖ Compare</button>
                </div>
            </form>
        </div>
    </div>

    @if(isset($country1) && isset($country2))

    {{-- Country Cards Side by Side --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

        {{-- Country 1 --}}
        <div class="card">
            <div style="background:#2D9F6F; padding:20px 24px; border-radius:14px 14px 0 0;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <img src="{{ $country1->flag }}" style="width:72px; height:48px; object-fit:cover; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.2);">
                    <div>
                        <h3 style="font-size:20px; font-weight:800; color:#fff;">{{ $country1->name }}</h3>
                        <p style="font-size:12px; color:rgba(255,255,255,.7);">{{ $country1->capital }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:0;">
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Region</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->region }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Sub Region</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->subregion }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Population</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ number_format($country1->population) }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Currency</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->currency }}</strong>
                    </div>
                    <div style="padding:10px 0; border-bottom:1px solid #E8ECF0; margin-top:4px;">
                        <p style="font-size:10px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">🌤 Weather</p>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Temperature</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->weatherLog->temperature ?? '-' }} °C</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Storm Risk</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->weatherLog->storm_risk ?? '-' }}</strong>
                    </div>
                    <div style="padding:10px 0; border-bottom:1px solid #E8ECF0; margin-top:4px;">
                        <p style="font-size:10px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">💰 Economy</p>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">GDP</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ number_format($country1->economicData->gdp ?? 0, 2) }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Inflation</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country1->economicData->inflation ?? '-' }} %</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:14px 0 0; margin-top:4px;">
                        <span style="font-size:14px; font-weight:700; color:#1A2332;">Total Risk Score</span>
                        @php $s1 = $country1->riskScore->total_score ?? 0; @endphp
                        <span class="badge {{ $s1 >= 70 ? 'badge-red' : ($s1 >= 40 ? 'badge-amber' : 'badge-green') }}" style="font-size:14px; padding:6px 14px;">{{ $s1 }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Country 2 --}}
        <div class="card">
            <div style="background:#3B82F6; padding:20px 24px; border-radius:14px 14px 0 0;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <img src="{{ $country2->flag }}" style="width:72px; height:48px; object-fit:cover; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,.2);">
                    <div>
                        <h3 style="font-size:20px; font-weight:800; color:#fff;">{{ $country2->name }}</h3>
                        <p style="font-size:12px; color:rgba(255,255,255,.7);">{{ $country2->capital }}</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="display:flex; flex-direction:column; gap:0;">
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Region</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->region }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Sub Region</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->subregion }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Population</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ number_format($country2->population) }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Currency</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->currency }}</strong>
                    </div>
                    <div style="padding:10px 0; border-bottom:1px solid #E8ECF0; margin-top:4px;">
                        <p style="font-size:10px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">🌤 Weather</p>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Temperature</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->weatherLog->temperature ?? '-' }} °C</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Storm Risk</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->weatherLog->storm_risk ?? '-' }}</strong>
                    </div>
                    <div style="padding:10px 0; border-bottom:1px solid #E8ECF0; margin-top:4px;">
                        <p style="font-size:10px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px;">💰 Economy</p>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">GDP</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ number_format($country2->economicData->gdp ?? 0, 2) }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="font-size:13px; color:#8B95A5;">Inflation</span>
                        <strong style="font-size:13px; color:#1A2332;">{{ $country2->economicData->inflation ?? '-' }} %</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:14px 0 0; margin-top:4px;">
                        <span style="font-size:14px; font-weight:700; color:#1A2332;">Total Risk Score</span>
                        @php $s2 = $country2->riskScore->total_score ?? 0; @endphp
                        <span class="badge {{ $s2 >= 70 ? 'badge-red' : ($s2 >= 40 ? 'badge-amber' : 'badge-green') }}" style="font-size:14px; padding:6px 14px;">{{ $s2 }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Risk Chart --}}
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:4px;">📊 Supply Chain Risk Components</h3>
            <p class="section-subtitle" style="margin-bottom:20px;">Side-by-side breakdown of risk score components</p>
            <canvas id="compareChart" height="100"></canvas>
        </div>
    </div>

    {{-- Auto Analysis --}}
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">🤖 Automatic Analysis</h3>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #3B82F6;">
                    <span style="font-size:16px; flex-shrink:0;">📌</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if($country1->population > $country2->population)
                            <b>{{ $country1->name }}</b> memiliki populasi lebih besar dibanding <b>{{ $country2->name }}</b>.
                        @else
                            <b>{{ $country2->name }}</b> memiliki populasi lebih besar dibanding <b>{{ $country1->name }}</b>.
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #3B82F6;">
                    <span style="font-size:16px; flex-shrink:0;">🗺</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if($country1->region == $country2->region)
                            Kedua negara berada pada region yang sama.
                        @else
                            Kedua negara berasal dari region yang berbeda.
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #3B82F6;">
                    <span style="font-size:16px; flex-shrink:0;">💱</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if($country1->currency == $country2->currency)
                            Kedua negara menggunakan mata uang yang sama.
                        @else
                            Kedua negara menggunakan mata uang yang berbeda.
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #E5A030;">
                    <span style="font-size:16px; flex-shrink:0;">⛈</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if(($country1->weatherLog->storm_risk ?? 0) > ($country2->weatherLog->storm_risk ?? 0))
                            {{ $country1->name }} memiliki tingkat risiko badai lebih tinggi.
                        @elseif(($country1->weatherLog->storm_risk ?? 0) < ($country2->weatherLog->storm_risk ?? 0))
                            {{ $country2->name }} memiliki tingkat risiko badai lebih tinggi.
                        @else
                            Tingkat risiko badai kedua negara sama.
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #E04B4B;">
                    <span style="font-size:16px; flex-shrink:0;">📈</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if(($country1->economicData->inflation ?? 0) > ($country2->economicData->inflation ?? 0))
                            Inflasi {{ $country1->name }} lebih tinggi.
                        @elseif(($country1->economicData->inflation ?? 0) < ($country2->economicData->inflation ?? 0))
                            Inflasi {{ $country2->name }} lebih tinggi.
                        @else
                            Kedua negara memiliki tingkat inflasi yang sama.
                        @endif
                    </p>
                </div>
                <div style="display:flex; align-items:flex-start; gap:10px; padding:12px; background:#F7F8FA; border-radius:8px; border-left:3px solid #E04B4B;">
                    <span style="font-size:16px; flex-shrink:0;">⚠</span>
                    <p style="font-size:13px; color:#1A2332;">
                        @if(($country1->riskScore->total_score ?? 0) > ($country2->riskScore->total_score ?? 0))
                            Supply Chain Risk negara <b>{{ $country1->name }}</b> lebih tinggi.
                        @elseif(($country1->riskScore->total_score ?? 0) < ($country2->riskScore->total_score ?? 0))
                            Supply Chain Risk negara <b>{{ $country2->name }}</b> lebih tinggi.
                        @else
                            Kedua negara memiliki Supply Chain Risk yang sama.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recommendation --}}
    @php
        $score1 = $country1->riskScore->total_score ?? 0;
        $score2 = $country2->riskScore->total_score ?? 0;
    @endphp
    <div class="card">
        <div class="card-body">
            <h3 style="font-size:16px; font-weight:700; color:#1A2332; margin-bottom:16px;">💡 Recommendation</h3>
            @if($score1 < $score2)
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px; padding:14px; background:#E8F5EF; border:1px solid #C3E6D4; border-radius:10px;">
                        <span style="font-size:20px;">✅</span>
                        <p style="font-size:13px; color:#1B7A4A; font-weight:600;"><b>{{ $country1->name }}</b> memiliki Total Supply Chain Risk lebih rendah.</p>
                    </div>
                    <div style="padding:14px; background:#F7F8FA; border-radius:10px;">
                        <p style="font-size:13px; color:#1A2332;">📦 Negara ini lebih direkomendasikan sebagai mitra perdagangan karena memiliki tingkat risiko rantai pasok yang lebih kecil.</p>
                    </div>
                    <div style="padding:14px; background:#F7F8FA; border-radius:10px;">
                        <p style="font-size:13px; color:#1A2332;">📈 Berdasarkan data cuaca, ekonomi, pelabuhan, dan berita, {{ $country1->name }} menunjukkan kondisi yang relatif lebih stabil.</p>
                    </div>
                </div>
            @elseif($score2 < $score1)
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px; padding:14px; background:#E8F5EF; border:1px solid #C3E6D4; border-radius:10px;">
                        <span style="font-size:20px;">✅</span>
                        <p style="font-size:13px; color:#1B7A4A; font-weight:600;"><b>{{ $country2->name }}</b> memiliki Total Supply Chain Risk lebih rendah.</p>
                    </div>
                    <div style="padding:14px; background:#F7F8FA; border-radius:10px;">
                        <p style="font-size:13px; color:#1A2332;">📦 Negara ini lebih direkomendasikan sebagai mitra perdagangan karena memiliki tingkat risiko rantai pasok yang lebih kecil.</p>
                    </div>
                    <div style="padding:14px; background:#F7F8FA; border-radius:10px;">
                        <p style="font-size:13px; color:#1A2332;">📈 Berdasarkan data cuaca, ekonomi, pelabuhan, dan berita, {{ $country2->name }} menunjukkan kondisi yang relatif lebih stabil.</p>
                    </div>
                </div>
            @else
                <div style="padding:14px; background:#F7F8FA; border-radius:10px;">
                    <p style="font-size:13px; color:#1A2332;">Kedua negara memiliki tingkat risiko yang hampir sama sehingga dapat dipilih sesuai kebutuhan bisnis.</p>
                </div>
            @endif
        </div>
    </div>

    @endif

</div>

@endsection

@push('scripts')
@if(isset($country1))
<script>
const ctx = document.getElementById('compareChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Weather', 'Economy', 'News', 'Port'],
        datasets: [
            {
                label: '{{ $country1->name }}',
                data: [
                    {{ $country1->riskScore->weather_score ?? 0 }},
                    {{ $country1->riskScore->economy_score ?? 0 }},
                    {{ $country1->riskScore->news_score ?? 0 }},
                    {{ $country1->riskScore->port_score ?? 0 }}
                ],
                backgroundColor: 'rgba(45,159,111,0.8)',
                borderRadius: 6,
            },
            {
                label: '{{ $country2->name }}',
                data: [
                    {{ $country2->riskScore->weather_score ?? 0 }},
                    {{ $country2->riskScore->economy_score ?? 0 }},
                    {{ $country2->riskScore->news_score ?? 0 }},
                    {{ $country2->riskScore->port_score ?? 0 }}
                ],
                backgroundColor: 'rgba(59,130,246,0.8)',
                borderRadius: 6,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        },
        scales: {
            y: { beginAtZero: true, max: 100, grid: { color: '#F0F2F5' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endif
@endpush
