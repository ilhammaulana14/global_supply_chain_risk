@extends('layouts.app')

@section('content')

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <div>
        <h2 class="section-title">🌍 Countries</h2>
        <p class="section-subtitle">Manage all countries in the Supply Chain Risk Intelligence System.</p>
    </div>
    <div class="stat-card green" style="min-width:140px;">
        <div class="stat-card-body" style="padding:14px 20px;">
            <div class="stat-card-label">Total Countries</div>
            <div class="stat-card-value">{{ $totalCountries }}</div>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card" style="margin-bottom:20px;">
    <div class="card-body">
        <form method="GET" action="{{ route('countries.index') }}" style="display:grid; grid-template-columns:1fr 200px auto; gap:12px; align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search country..." class="search-input">
            <select name="region" class="search-input">
                <option value="">All Region</option>
                @foreach($regions as $region)
                    <option value="{{ $region }}" {{ request('region')==$region ? 'selected' : '' }}>{{ $region }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary">Search</button>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card" style="margin-bottom:20px;">
    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="text-align:center;">No</th>
                    <th style="text-align:center;">Flag</th>
                    <th>Country</th>
                    <th style="text-align:center;">ISO</th>
                    <th style="text-align:center;">Region</th>
                    <th style="text-align:center;">Currency</th>
                    <th style="text-align:center;">Population</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($countries as $country)
                <tr>
                    <td style="text-align:center;">{{ $countries->firstItem() + $loop->index }}</td>
                    <td style="text-align:center;"><img src="{{ $country->flag }}" style="width:40px; height:28px; border-radius:4px; object-fit:cover; box-shadow:0 1px 3px rgba(0,0,0,.1);" alt="flag"></td>
                    <td style="font-weight:600;">{{ $country->name }}</td>
                    <td style="text-align:center;"><span class="badge badge-blue">{{ $country->code }}</span></td>
                    <td style="text-align:center;"><span class="badge badge-green">{{ $country->region ?: '-' }}</span></td>
                    <td style="text-align:center;">{{ $country->currency ?: '-' }}</td>
                    <td style="text-align:center;">{{ number_format($country->population) }}</td>
                    <td style="text-align:center;">
                        <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                            <a href="{{ route('countries.show', $country->id) }}" class="btn btn-primary" style="padding:6px 14px; font-size:12px;">Detail</a>
                            <form action="{{ route('countries.favorite', $country->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn {{ $country->isFavoritedBy(auth()->user()) ? 'btn-amber' : 'btn-secondary' }}" style="padding:6px 12px; font-size:12px;">
                                    {{ $country->isFavoritedBy(auth()->user()) ? '★ Favorited' : '☆ Favorite' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center; padding:40px; color:#8B95A5;">No country data found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div style="display:flex; justify-content:flex-end;">{{ $countries->links() }}</div>

@endsection
