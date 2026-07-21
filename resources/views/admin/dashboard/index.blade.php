@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div>

        <h2 class="text-3xl font-bold text-slate-800">
            🌍 Supply Chain Risk Dashboard
        </h2>

        <p class="text-gray-500 mt-2">
            Global Supply Chain Risk Intelligence Monitoring
        </p>

    </div>

    {{-- Summary Cards --}}
{{-- Dashboard Action --}}
<div class="bg-white rounded-xl shadow p-6">

    <h3 class="text-xl font-bold mb-5">
        ⚙ Dashboard Action
    </h3>

    <div class="flex flex-wrap gap-4">

        {{-- Refresh Weather --}}
        <form
    action="{{ route('weather.refresh') }}"
    method="POST"
    onsubmit="return submitButton(this,'Updating Weather...')">

    @csrf

    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

        🌦 Refresh Weather

    </button>

</form>

        {{-- Import Economy --}}
        <form
    action="{{ route('economy.import') }}"
    method="POST"
    onsubmit="return submitButton(this,'Importing Economy...')">

    @csrf

    <button
        type="submit"
        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">

        💰 Import Economy

    </button>

</form>

        {{-- Generate News --}}
        <form
    action="{{ route('news.generate') }}"
    method="POST"
    onsubmit="return submitButton(this,'Generating News...')">

    @csrf

    <button
        type="submit"
        class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg">

        📰 Generate News

    </button>

</form>

        {{-- Generate Risk --}}
        <form
    action="{{ route('risk.generate') }}"
    method="GET"
    onsubmit="return submitButton(this,'Calculating Risk Score...')">

    <button
        type="submit"
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">

        ⚠ Generate Risk Score

    </button>

</form>

    </div>

</div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Countries</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalCountries }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Weather</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $totalWeather }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Ports</p>
            <h2 class="text-4xl font-bold text-indigo-600 mt-2">
                {{ $totalPorts }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">Economy</p>
            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $totalEconomy }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">News</p>
            <h2 class="text-4xl font-bold text-orange-600 mt-2">
                {{ $totalNews }}
            </h2>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-gray-500">High Risk</p>
            <h2 class="text-4xl font-bold text-red-600 mt-2">
                {{ $highRisk }}
            </h2>
        </div>

    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-5">
                📊 Risk Distribution
            </h3>

            <canvas id="riskChart"></canvas>

        </div>

        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-5">
                📈 Top 10 Highest Risk Countries
            </h3>

            <canvas id="barChart"></canvas>

        </div>

    </div>

    {{-- World Map --}}
    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="text-xl font-bold mb-5">
            🌍 Global Supply Chain Risk Map
        </h3>

        <div
            id="worldMap"
            class="rounded-lg border"
            style="height:600px;">
        </div>

    </div>

    {{-- Bottom Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Risk --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4">
                🔴 Top 10 Highest Risk Countries
            </h3>

            <table class="min-w-full">

                <thead class="border-b">

                    <tr>

                        <th class="text-left py-3">Country</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Risk</th>

                    </tr>

                </thead>

                <tbody>

                @foreach($topRisk as $risk)

                    <tr class="border-b">

                        <td class="py-3">
                            {{ $risk->country->name }}
                        </td>

                        <td class="text-center">
                            {{ $risk->total_score }}
                        </td>

                        <td class="text-center">

                            @if($risk->risk_level=="High")

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">

                                    High

                                </span>

                            @elseif($risk->risk_level=="Medium")

                                <span class="bg-yellow-400 px-3 py-1 rounded-full">

                                    Medium

                                </span>

                            @else

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full">

                                    Low

                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

        {{-- Latest News --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h3 class="text-xl font-bold mb-4">

                📰 Latest News

            </h3>

            @forelse($latestNews as $item)

                <div class="border-b py-3">

                    <p class="font-semibold">

                        {{ $item->title }}

                    </p>

                    <p class="text-gray-500 text-sm">

                        {{ $item->country->name ?? '-' }}

                    </p>

                </div>

            @empty

                <p class="text-gray-500">

                    No news available.

                </p>

            @endforelse

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

console.log("Chart Loaded");

console.log(@json($topRisk));

console.log(@json($mapCountries));

document.addEventListener('DOMContentLoaded', function () {

    // PIE CHART

    new Chart(document.getElementById('riskChart'), {

        type: 'pie',

        data: {

            labels: ['Low','Medium','High'],

            datasets: [{

                data: [

                    {{ $lowRisk }},

                    {{ $mediumRisk }},

                    {{ $highRisk }}

                ],

                backgroundColor: [

                    '#22c55e',

                    '#f59e0b',

                    '#ef4444'

                ]

            }]

        }

    });

    // BAR CHART

    new Chart(document.getElementById('barChart'), {

        type: 'bar',

        data: {

            labels: [

                @foreach($topRisk as $risk)

                    "{{ $risk->country->name }}",

                @endforeach

            ],

            datasets: [{

                label: 'Risk Score',

                data: [

                    @foreach($topRisk as $risk)

                        {{ $risk->total_score }},

                    @endforeach

                ]

            }]

        },

        options: {

            responsive: true,

            scales: {

                y: {

                    beginAtZero: true,

                    max: 100

                }

            }

        }

    });

    // LEAFLET MAP

    const countries = @json($mapCountries);

    const map = L.map('worldMap').setView([20,0],2);

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution:'© OpenStreetMap'

        }

    ).addTo(map);

    countries.forEach(function(country){

        if(country.latitude == null || country.longitude == null){

            return;

        }

        let color="green";

        let score=0;

        let level="-";

        if(country.risk_score){

            score=country.risk_score.total_score;

            level=country.risk_score.risk_level;

            if(level==="High"){

                color="red";

            }else if(level==="Medium"){

                color="orange";

            }

        }

        L.circleMarker(

            [

                country.latitude,

                country.longitude

            ],

            {

                radius:7,

                color:color,

                fillColor:color,

                fillOpacity:0.8

            }

        )

        .addTo(map)

        .bindPopup(

            `<b>${country.name}</b><br>
            Risk Score : ${score}<br>
            Risk Level : ${level}`

        );

    });

});

</script>
@push('scripts')

<script>

function submitButton(form,text){

    if(!confirm("Apakah Anda yakin ingin menjalankan proses ini?")){

        return false;

    }

    let button=form.querySelector("button");

    button.disabled=true;

    button.innerHTML="⏳ "+text;

    return true;

}

</script>

@endpush
@endpush
