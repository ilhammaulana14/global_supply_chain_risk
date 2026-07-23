@extends('layouts.admin')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header --}}
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">📊</span>
                <div>
                    <h2 class="section-title">Admin Dashboard</h2>
                    <p class="section-subtitle">Overview data and statistics of SCRI system</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Row --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
        <div class="stat-card blue">
            <div class="stat-card-body">
                <div class="stat-card-label">Total User</div>
                <div class="stat-card-value">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="stat-card green">
            <div class="stat-card-body">
                <div class="stat-card-label">Total Negara</div>
                <div class="stat-card-value">{{ $totalCountries }}</div>
            </div>
        </div>
        <div class="stat-card amber">
            <div class="stat-card-body">
                <div class="stat-card-label">Total Pelabuhan</div>
                <div class="stat-card-value">{{ $totalPorts }}</div>
            </div>
        </div>
    </div>

</div>

@endsection
