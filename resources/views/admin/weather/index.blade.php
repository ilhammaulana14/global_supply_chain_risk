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
                🌤 Weather Monitoring
            </h2>

            <p class="text-gray-500 mt-2">
                Monitor cuaca seluruh negara secara realtime
            </p>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Countries</p>
            <h2 class="text-4xl font-bold mt-2">{{ $totalCountry }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Temp</p>
            <h2 class="text-4xl font-bold text-red-500 mt-2">
                {{ $avgTemp }}°C
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Rain</p>
            <h2 class="text-4xl font-bold text-blue-500 mt-2">
                {{ $avgRain }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Highest Temp</p>
            <h2 class="text-4xl font-bold text-orange-500 mt-2">
                {{ $highestTemp }}°C
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Storm Risk</p>
            <h2 class="text-4xl font-bold text-red-600 mt-2">
                {{ $stormCount }}
            </h2>
        </div>

    </div>

    {{-- Search --}}
    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex gap-4">

            <form method="GET" class="flex flex-1 gap-4">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search country..."
                    class="flex-1 border rounded-xl px-4 py-3">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

                    Search

                </button>

            </form>

            <form
                action="{{ route('weather.refresh') }}"
                method="POST">

                @csrf

                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                    🔄 Refresh All

                </button>

            </form>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-800 text-white">

            <tr>

                <th class="px-5 py-4">No</th>
                <th class="px-5 py-4 text-left">Country</th>
                <th class="px-5 py-4 text-center">Temperature</th>
                <th class="px-5 py-4 text-center">Rainfall</th>
                <th class="px-5 py-4 text-center">Wind</th>
                <th class="px-5 py-4 text-center">Storm</th>
                <th class="px-5 py-4 text-center">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($countries as $country)

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center">
                        {{ $countries->firstItem() + $loop->index }}
                    </td>

                    <td class="px-5 py-4 font-semibold">
                        {{ $country->name }}
                    </td>

                    <td class="text-center">

                        @if($country->weatherLog)

                            @php
                                $temp = $country->weatherLog->temperature;
                            @endphp

                            @if($temp >= 35)

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">

                            @elseif($temp >= 25)

                                <span class="bg-yellow-400 px-3 py-1 rounded-full">

                            @else

                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full">

                            @endif

                                {{ $temp }}°C

                                </span>

                        @else

                            -

                        @endif

                    </td>

                    <td class="text-center">
                        {{ $country->weatherLog->rainfall ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $country->weatherLog->wind_speed ?? '-' }}
                    </td>

                    <td class="text-center">

                        @if(!$country->weatherLog)

                            -

                        @elseif($country->weatherLog->storm_risk == 3)

                            <span class="bg-red-600 text-white px-3 py-1 rounded-full">
                                High
                            </span>

                        @elseif($country->weatherLog->storm_risk == 2)

                            <span class="bg-yellow-400 px-3 py-1 rounded-full">
                                Medium
                            </span>

                        @elseif($country->weatherLog->storm_risk == 1)

                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">
                                Low
                            </span>

                        @else

                            <span class="bg-gray-300 px-3 py-1 rounded-full">
                                None
                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <form
                            action="{{ route('weather.update',$country->id) }}"
                            method="POST">

                            @csrf

                            <button
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                Refresh

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" class="text-center py-8 text-gray-500">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex justify-end">

        {{ $countries->links() }}

    </div>

</div>

@endsection
