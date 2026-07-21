@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-8">
    Dashboard
</h2>

{{-- ===========================
STATISTIC
=========================== --}}

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500">Countries</p>
        <h2 class="text-4xl font-bold mt-2">
            {{ $countryCount }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500">Ports</p>
        <h2 class="text-4xl font-bold mt-2">
            {{ $portCount }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500">News</p>
        <h2 class="text-4xl font-bold mt-2">
            {{ $newsCount }}
        </h2>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-gray-500">Average Risk</p>
        <h2 class="text-4xl font-bold mt-2">
            {{ $averageRisk }}
        </h2>
    </div>

</div>

{{-- ===========================
TOP RISK
=========================== --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="text-xl font-bold mb-5">
            Top 5 Highest Risk Countries
        </h3>

        <table class="w-full">

            <thead>

            <tr class="border-b">

                <th class="text-left py-2">Country</th>
                <th class="text-center">Score</th>
                <th class="text-center">Level</th>

            </tr>

            </thead>

            <tbody>

            @foreach($topCountries as $risk)

                <tr class="border-b">

                    <td class="py-2">
                        {{ $risk->country->name ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $risk->total_score }}
                    </td>

                    <td class="text-center">

                        @if($risk->risk_level=="High")

                            <span class="text-red-600 font-bold">
                                High
                            </span>

                        @elseif($risk->risk_level=="Medium")

                            <span class="text-yellow-600 font-bold">
                                Medium
                            </span>

                        @else

                            <span class="text-green-600 font-bold">
                                Low
                            </span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

{{-- ===========================
LATEST NEWS
=========================== --}}

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="text-xl font-bold mb-5">

            Latest News

        </h3>

        @forelse($latestNews as $news)

            <div class="border-b py-3">

                <h4 class="font-semibold">

                    {{ $news->title }}

                </h4>

                <p class="text-gray-500 text-sm">

                    {{ $news->source }}

                </p>

            </div>

        @empty

            <p class="text-gray-500">

                No news available.

            </p>

        @endforelse

    </div>

</div>

{{-- ===========================
RISK DISTRIBUTION
=========================== --}}

<div class="bg-white rounded-xl shadow p-6 mt-8">

    <h3 class="text-xl font-bold mb-5">

        Risk Distribution

    </h3>

    <div class="grid grid-cols-3 text-center">

        <div>

            <h2 class="text-red-600 text-4xl font-bold">

                {{ $high }}

            </h2>

            <p>High</p>

        </div>

        <div>

            <h2 class="text-yellow-500 text-4xl font-bold">

                {{ $medium }}

            </h2>

            <p>Medium</p>

        </div>

        <div>

            <h2 class="text-green-600 text-4xl font-bold">

                {{ $low }}

            </h2>

            <p>Low</p>

        </div>

    </div>

</div>

{{-- ===========================
CHART
=========================== --}}

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="font-bold text-xl mb-5">

            Risk Distribution

        </h3>

        <canvas id="riskChart"></canvas>

    </div>

    <div class="bg-white rounded-xl shadow p-6">

        <h3 class="font-bold text-xl mb-5">

            Highest Risk Countries

        </h3>

        <canvas id="barChart"></canvas>

    </div>

</div>

{{-- ===========================
WORLD MAP
=========================== --}}

<div class="bg-white rounded-xl shadow p-6 mt-8">

    <h3 class="text-xl font-bold mb-5">

        🌍 Global Supply Chain Risk Map

    </h3>

    <div id="worldMap" style="height:600px;"></div>

</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded',function(){

// PIE

const chart=@json($chart);

new Chart(document.getElementById('riskChart'),{

    type:'pie',

    data:{

        labels:chart.labels,

        datasets:[{

            data:chart.data,

            backgroundColor:[
                '#ef4444',
                '#f59e0b',
                '#22c55e'
            ]

        }]

    }

});

// BAR

const bar=@json($barChart);

new Chart(document.getElementById('barChart'),{

    type:'bar',

    data:{

        labels:bar.labels,

        datasets:[{

            label:'Risk Score',

            data:bar.scores

        }]

    },

    options:{

        responsive:true,

        scales:{

            y:{

                beginAtZero:true,

                max:100

            }

        }

    }

});

// MAP

const countries=@json($mapCountries);

const map=L.map('worldMap').setView([20,0],2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{

    attribution:'© OpenStreetMap'

}).addTo(map);

countries.forEach(function(country){

    if(country.latitude==null || country.longitude==null){

        return;

    }

    let color="green";
    let score=0;
    let level="-";

    if(country.risk_score){

        score=country.risk_score.total_score;
        level=country.risk_score.risk_level;

        if(level=="High"){

            color="red";

        }else if(level=="Medium"){

            color="orange";

        }

    }

    L.circleMarker(

        [country.latitude,country.longitude],

        {

            radius:7,

            color:color,

            fillColor:color,

            fillOpacity:0.8

        }

    )

    .addTo(map)

    .bindPopup(

        "<b>"+country.name+"</b><br>" +

        "Risk Score : "+score+"<br>"+

        "Risk Level : "+level

    );

});

});

</script>

@endpush
