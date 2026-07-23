@extends('layouts.admin')

@section('content')

<div style="max-width:800px; margin:0 auto;">
    <div class="card">
        <div class="card-body">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                <span style="width:40px; height:40px; border-radius:10px; background:#EBF2FF; color:#2563EB; display:flex; align-items:center; justify-content:center; font-size:20px;">✏️</span>
                <div>
                    <h2 class="section-title">Edit Port</h2>
                    <p class="section-subtitle">Perbarui data pelabuhan.</p>
                </div>
            </div>

            <form action="{{ route('admin.ports.update', $port) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                    {{-- Country --}}
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Negara</label>
                        <select name="country_id" class="search-input" style="width:100%;">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $port->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Code --}}
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Kode Port</label>
                        <input type="text" name="code" value="{{ old('code', $port->code) }}" class="search-input" style="width:100%; box-sizing:border-box;">
                        @error('code')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div style="grid-column:span 2;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Nama Pelabuhan</label>
                        <input type="text" name="name" value="{{ old('name', $port->name) }}" class="search-input" style="width:100%; box-sizing:border-box;">
                        @error('name')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Latitude --}}
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Latitude</label>
                        <input type="number" step="any" name="latitude" value="{{ old('latitude', $port->latitude) }}" class="search-input" style="width:100%; box-sizing:border-box;">
                        @error('latitude')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Longitude --}}
                    <div>
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Longitude</label>
                        <input type="number" step="any" name="longitude" value="{{ old('longitude', $port->longitude) }}" class="search-input" style="width:100%; box-sizing:border-box;">
                        @error('longitude')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Congestion --}}
                    <div style="grid-column:span 2;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#8B95A5; text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">Tingkat Kemacetan (%)</label>
                        <input type="number" min="0" max="100" name="congestion_level" value="{{ old('congestion_level', $port->congestion_level) }}" class="search-input" style="width:100%; box-sizing:border-box;">
                        @error('congestion_level')
                            <span style="color:#C33B3B; font-size:11px; font-weight:600; margin-top:4px; display:block;">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div style="display:flex; gap:12px; margin-top:32px; border-top:1px solid #F0F2F5; padding-top:20px;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.ports.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
