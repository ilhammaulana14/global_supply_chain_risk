@extends('layouts.admin')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">⚙</span>
                <div>
                    <h2 class="section-title">Admin Control Panel</h2>
                    <p class="section-subtitle">SCRI System Administration & Management Hub</p>
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

    {{-- Stats Grid --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(170px, 1fr)); gap:16px;">
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Total Users</div>
                <div class="stat-card-value">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Total Countries</div>
                <div class="stat-card-value">{{ $totalCountries }}</div>
            </div>
        </div>
        <div class="stat-card indigo">
            <div class="stat-card-body">
                <div class="stat-card-label">Monitored Ports</div>
                <div class="stat-card-value">{{ $totalPorts }}</div>
            </div>
        </div>
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Weather Records</div>
                <div class="stat-card-value">{{ $totalWeather }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Economy Records</div>
                <div class="stat-card-value">{{ $totalEconomy }}</div>
            </div>
        </div>
        <div class="stat-card red">
            <div class="stat-card-body">
                <div class="stat-card-label">News Articles</div>
                <div class="stat-card-value">{{ $totalNews }}</div>
            </div>
        </div>
    </div>

    {{-- Main Admin Rows --}}
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px;">
        
        {{-- Left: Latest Users --}}
        <div class="card">
            <div class="card-body" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; box-sizing:border-box;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                    <div>
                        <h3 class="section-title" style="font-size:15px;">👥 Latest Registered Users</h3>
                        <p class="section-subtitle">Recently created user accounts</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="font-size:12px; padding:6px 12px;">Manage Users</a>
                </div>

                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th style="text-align:center;">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestUsers as $user)
                                <tr>
                                    <td style="font-weight:600;">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td style="text-align:center;">
                                        @if($user->role == 'admin')
                                            <span class="badge badge-red">Admin</span>
                                        @else
                                            <span class="badge badge-green">User</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right: System Overview metrics --}}
        <div class="card">
            <div class="card-body" style="display:flex; flex-direction:column; justify-content:space-between; height:100%; box-sizing:border-box;">
                <div style="margin-bottom:16px;">
                    <h3 class="section-title" style="font-size:15px;">📊 Dataset & Parameter Summary</h3>
                    <p class="section-subtitle">Real-time status of monitored parameters</p>
                </div>

                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="color:#8B95A5;">Average Risk Score</span>
                        <strong style="color:#1A2332;">{{ $averageRisk }}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="color:#8B95A5;">Critical Ports (>70% Congestion)</span>
                        <strong style="color:#E04B4B;">{{ $criticalPorts }} Ports</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="color:#8B95A5;">Average Congestion Level</span>
                        <strong style="color:#1A2332;">{{ $averageCongestion }}%</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0F2F5;">
                        <span style="color:#8B95A5;">Average Global Temperature</span>
                        <strong style="color:#1A2332;">{{ $averageTemperature }} °C</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding:10px 0;">
                        <span style="color:#8B95A5;">High Risk Countries</span>
                        <strong style="color:#E04B4B;">{{ $highRisk }}</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
function submitButton(form, text) {
    if(!confirm("Are you sure you want to run this process?")) return false;
    let button = form.querySelector("button");
    button.disabled = true;
    button.innerHTML = "⏳ " + text;
    return true;
}
</script>
@endpush
