@extends('layouts.app')

@section('content')

<div style="display:flex; flex-direction:column; gap:24px;">

    {{-- Header --}}
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; justify-content:between;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#E8F5EF; color:#2D9F6F; display:flex; align-items:center; justify-content:center; font-size:20px;">🌍</span>
                <div>
                    <h2 class="section-title">Countries</h2>
                    <p class="section-subtitle">Daftar negara untuk Supply Chain Risk Intelligence</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <div class="card">
        <div class="card-body">
            <form method="GET" style="display:flex; gap:12px; align-items:center;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari negara berdasarkan nama atau kode..." class="search-input" style="flex:1;">
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
                        <th style="width:70px; text-align:center;">Flag</th>
                        <th>Country</th>
                        <th style="text-align:center;">Risk Score</th>
                        <th style="text-align:center;">Risk Level</th>
                        <th style="text-align:center;">Latitude</th>
                        <th style="text-align:center;">Longitude</th>
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($countries as $country)
                    <tr>
                        <td style="text-align:center;">
                            @if($country->flag)
                                <img src="{{ $country->flag }}" style="width:40px; height:28px; border-radius:4px; object-fit:cover; box-shadow:0 1px 3px rgba(0,0,0,.1);" alt="flag">
                            @else
                                <span style="font-size:20px;">🌍</span>
                            @endif
                        </td>
                        <td style="font-weight:600;">
                            {{ $country->name }}
                        </td>
                        <td style="text-align:center; font-weight:700;">
                            {{ $country->riskScore->total_score ?? '-' }}
                        </td>
                        <td style="text-align:center;">
                            @php
                                $level = $country->riskScore->risk_level ?? '-';
                            @endphp
                            @if($level == 'High')
                                <span class="badge badge-red">High</span>
                            @elseif($level == 'Medium')
                                <span class="badge badge-amber">Medium</span>
                            @elseif($level == 'Low')
                                <span class="badge badge-green">Low</span>
                            @else
                                <span class="badge" style="background:#F4F5F7; color:#8B95A5;">-</span>
                            @endif
                        </td>
                        <td style="text-align:center; color:#8B95A5;">
                            {{ $country->latitude ?? '-' }}
                        </td>
                        <td style="text-align:center; color:#8B95A5;">
                            {{ $country->longitude ?? '-' }}
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                                <a href="{{ route('countries.show', $country->id) }}" class="btn btn-secondary" style="padding:6px 14px; font-size:12px;">Detail</a>
                                <form action="{{ route('countries.favorite', $country->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn {{ $country->isFavoritedBy(auth()->user()) ? 'btn-amber' : 'btn-secondary' }}" style="padding:6px 12px; font-size:12px;">
                                        {{ $country->isFavoritedBy(auth()->user()) ? '★ Favorited' : '☆ Favorite' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px 24px; border-top:1px solid #F0F2F5; display:flex; justify-content:flex-end;">
            {{ $countries->links() }}
        </div>
    </div>

</div>

@endsection
