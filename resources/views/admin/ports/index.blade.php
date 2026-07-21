@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-5 py-3 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
<div class="flex justify-between items-center">

    <div>

        <h2 class="text-3xl font-bold text-slate-800">
            ⚓ Port Monitoring
        </h2>

        <p class="text-gray-500 mt-2">
            Monitor pelabuhan dan tingkat kemacetan logistik.
        </p>

    </div>

    <form action="{{ route('ports.import') }}" method="POST">

        @csrf

        <button
            class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-3 rounded-xl">

            🚢 Import Port Data

        </button>

    </form>

</div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Total Ports
            </p>

            <h2 class="text-4xl font-bold mt-2">

                {{ $totalPorts }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">

                Average Congestion

            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-2">

                {{ $averageCongestion }}%

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">

                Safe Ports

            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-2">

                {{ $safePorts }}

            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">

                Critical Ports

            </p>

            <h2 class="text-4xl font-bold text-red-600 mt-2">

                {{ $criticalPorts }}

            </h2>

        </div>

    </div>

        {{-- Search --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <form method="GET">

            <div class="flex gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search port, country or code..."
                    class="flex-1 border rounded-xl px-4 py-3">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

                    Search

                </button>

            </div>

        </form>

    </div>

    {{-- Map --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <h3 class="text-xl font-bold mb-5">

            🌍 Global Port Map

        </h3>

        <div
            id="map"
            class="rounded-xl"
            style="height:500px;">
        </div>

    </div>

        {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-800 text-white">

                <tr>

                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4 text-left">Port</th>
                    <th class="px-5 py-4 text-left">Country</th>
                    <th class="px-5 py-4 text-center">Code</th>
                    <th class="px-5 py-4 text-center">Type</th>
                    <th class="px-5 py-4 text-center">Congestion</th>
                    <th class="px-5 py-4 text-center">Status</th>

                </tr>

            </thead>

            <tbody>

            @forelse($ports as $port)

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center">

                        {{ $ports->firstItem() + $loop->index }}

                    </td>

                    <td class="px-5 py-4 font-semibold">

                        {{ $port->name }}

                    </td>

                    <td>

                        {{ $port->country->name ?? '-' }}

                    </td>

                    <td class="text-center">

                        {{ $port->code }}

                    </td>

                    <td class="text-center">

                        {{ $port->type }}

                    </td>

                    <td class="px-5 py-4">

                        <div class="w-full bg-gray-200 rounded-full h-3">

                            <div

                                class="h-3 rounded-full

                                @if($port->congestion_level < 40)

                                    bg-green-500

                                @elseif($port->congestion_level <= 70)

                                    bg-yellow-500

                                @else

                                    bg-red-500

                                @endif"

                                style="width: {{ $port->congestion_level }}%">

                            </div>

                        </div>

                        <p class="text-center text-sm mt-2">

                            {{ $port->congestion_level }}%

                        </p>

                    </td>

                    <td class="text-center">

                        @if($port->congestion_level < 40)

                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">

                                Safe

                            </span>

                        @elseif($port->congestion_level <=70)

                            <span class="bg-yellow-400 px-3 py-1 rounded-full">

                                Warning

                            </span>

                        @else

                            <span class="bg-red-600 text-white px-3 py-1 rounded-full">

                                Critical

                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="py-8 text-center text-gray-500">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex justify-end">

        {{ $ports->links() }}

    </div>

    </div>

@endsection

@push('scripts')

<script>

const map = L.map('map').setView([20,0],2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{

    attribution:'© OpenStreetMap'

}).addTo(map);

@foreach($mapPorts as $port)

@if($port->latitude && $port->longitude)

L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
])

.addTo(map)

.bindPopup(`

<b>{{ $port->name }}</b><br>

Country :
{{ $port->country->name ?? '-' }}

<br>

Congestion :
{{ $port->congestion_level }}%

`);

@endif

@endforeach

</script>

@endpush
