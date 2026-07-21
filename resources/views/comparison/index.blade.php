@extends('layouts.app')

@section('content')

<div class="space-y-8">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <div class="flex items-center justify-between mb-8">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">

                    🌍 Country Comparison Engine

                </h2>

                <p class="text-gray-500 mt-2">

                    Compare countries based on demographic, economic, weather and supply chain risk indicators.

                </p>

            </div>

        </div>

        <form action="{{ route('comparison.compare') }}" method="POST">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>

                    <label class="block font-semibold mb-2">

                        Country 1

                    </label>

                    <select
                        name="country1"
                        class="w-full border rounded-xl px-4 py-3">

                        @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ isset($country1) && $country1->id == $country->id ? 'selected' : '' }}>

                                {{ $country->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Country 2

                    </label>

                    <select
                        name="country2"
                        class="w-full border rounded-xl px-4 py-3">

                        @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                                {{ isset($country2) && $country2->id == $country->id ? 'selected' : '' }}>

                                {{ $country->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

            <button
                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl">

                Compare Countries

            </button>

        </form>

        @if(isset($country1) && isset($country2))

<hr class="my-10">

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <!-- Country 1 -->
    <div class="bg-blue-50 rounded-2xl p-6 border">

        <div class="flex items-center gap-4">

            <img
                src="{{ $country1->flag }}"
                class="w-20 h-14 object-cover rounded shadow">

            <div>

                <h3 class="text-2xl font-bold">

                    {{ $country1->name }}

                </h3>

                <p class="text-gray-500">

                    {{ $country1->capital }}

                </p>

            </div>

        </div>

        <div class="mt-6 space-y-3">

            <div class="flex justify-between">

                <span>Region</span>

                <b>{{ $country1->region }}</b>

            </div>

            <div class="flex justify-between">

                <span>Sub Region</span>

                <b>{{ $country1->subregion }}</b>

            </div>

            <div class="flex justify-between">

                <span>Population</span>

                <b>{{ number_format($country1->population) }}</b>

            </div>

            <div class="flex justify-between">

                <span>Currency</span>

                <b>{{ $country1->currency }}</b>

            </div>

            <hr>

            <div class="flex justify-between">

                <span>Temperature</span>

                <b>

                    {{ $country1->weatherLog->temperature ?? '-' }} °C

                </b>

            </div>

            <div class="flex justify-between">

                <span>Storm Risk</span>

                <b>

                    {{ $country1->weatherLog->storm_risk ?? '-' }}

                </b>

            </div>

            <hr>

            <div class="flex justify-between">

                <span>GDP</span>

                <b>

                    {{ number_format($country1->economicData->gdp ?? 0,2) }}

                </b>

            </div>

            <div class="flex justify-between">

                <span>Inflation</span>

                <b>

                    {{ $country1->economicData->inflation ?? '-' }} %

                </b>

            </div>

            <hr>

            <div class="flex justify-between text-red-600 text-xl">

                <span>

                    Total Risk Score

                </span>

                <b>

                    {{ $country1->riskScore->total_score ?? 0 }}

                </b>

            </div>

        </div>

    </div>

    <!-- Country 2 -->

    <div class="bg-green-50 rounded-2xl p-6 border">

        <div class="flex items-center gap-4">

            <img
                src="{{ $country2->flag }}"
                class="w-20 h-14 object-cover rounded shadow">

            <div>

                <h3 class="text-2xl font-bold">

                    {{ $country2->name }}

                </h3>

                <p class="text-gray-500">

                    {{ $country2->capital }}

                </p>

            </div>

        </div>

        <div class="mt-6 space-y-3">

            <div class="flex justify-between">

                <span>Region</span>

                <b>{{ $country2->region }}</b>

            </div>

            <div class="flex justify-between">

                <span>Sub Region</span>

                <b>{{ $country2->subregion }}</b>

            </div>

            <div class="flex justify-between">

                <span>Population</span>

                <b>{{ number_format($country2->population) }}</b>

            </div>

            <div class="flex justify-between">

                <span>Currency</span>

                <b>{{ $country2->currency }}</b>

            </div>

            <hr>

            <div class="flex justify-between">

                <span>Temperature</span>

                <b>

                    {{ $country2->weatherLog->temperature ?? '-' }} °C

                </b>

            </div>

            <div class="flex justify-between">

                <span>Storm Risk</span>

                <b>

                    {{ $country2->weatherLog->storm_risk ?? '-' }}

                </b>

            </div>

            <hr>

            <div class="flex justify-between">

                <span>GDP</span>

                <b>

                    {{ number_format($country2->economicData->gdp ?? 0,2) }}

                </b>

            </div>

            <div class="flex justify-between">

                <span>Inflation</span>

                <b>

                    {{ $country2->economicData->inflation ?? '-' }} %

                </b>

            </div>

            <hr>

            <div class="flex justify-between text-red-600 text-xl">

                <span>

                    Total Risk Score

                </span>

                <b>

                    {{ $country2->riskScore->total_score ?? 0 }}

                </b>

            </div>

        </div>

    </div>

</div>

<div class="mt-10 bg-white rounded-2xl shadow-lg p-6">

    <h3 class="text-2xl font-bold text-slate-800 mb-6">

        📊 Supply Chain Risk Components

    </h3>

    <canvas id="compareChart" height="120"></canvas>

</div>


<div class="mt-10 bg-gray-100 rounded-2xl p-8">

    <h3 class="text-2xl font-bold mb-6">

        🤖 Automatic Analysis

    </h3>

    <ul class="space-y-4 list-disc ml-6">

        <li>

            @if($country1->population > $country2->population)

                <b>{{ $country1->name }}</b> memiliki populasi lebih besar dibanding <b>{{ $country2->name }}</b>.

            @else

                <b>{{ $country2->name }}</b> memiliki populasi lebih besar dibanding <b>{{ $country1->name }}</b>.

            @endif

        </li>

        <li>

            @if($country1->region == $country2->region)

                Kedua negara berada pada region yang sama.

            @else

                Kedua negara berasal dari region yang berbeda.

            @endif

        </li>

        <li>

            @if($country1->currency == $country2->currency)

                Kedua negara menggunakan mata uang yang sama.

            @else

                Kedua negara menggunakan mata uang yang berbeda.

            @endif

        </li>

        <li>

            @if(($country1->weatherLog->storm_risk ?? 0) > ($country2->weatherLog->storm_risk ?? 0))

                {{ $country1->name }} memiliki tingkat risiko badai lebih tinggi.

            @elseif(($country1->weatherLog->storm_risk ?? 0) < ($country2->weatherLog->storm_risk ?? 0))

                {{ $country2->name }} memiliki tingkat risiko badai lebih tinggi.

            @else

                Tingkat risiko badai kedua negara sama.

            @endif

        </li>

        <li>

            @if(($country1->economicData->inflation ?? 0) > ($country2->economicData->inflation ?? 0))

                Inflasi {{ $country1->name }} lebih tinggi.

            @elseif(($country1->economicData->inflation ?? 0) < ($country2->economicData->inflation ?? 0))

                Inflasi {{ $country2->name }} lebih tinggi.

            @else

                Kedua negara memiliki tingkat inflasi yang sama.

            @endif

        </li>

        <li>

            @if(($country1->riskScore->total_score ?? 0) > ($country2->riskScore->total_score ?? 0))

                Supply Chain Risk negara <b>{{ $country1->name }}</b> lebih tinggi.

            @elseif(($country1->riskScore->total_score ?? 0) < ($country2->riskScore->total_score ?? 0))

                Supply Chain Risk negara <b>{{ $country2->name }}</b> lebih tinggi.

            @else

                Kedua negara memiliki Supply Chain Risk yang sama.

            @endif

        </li>

    </ul>

</div>


<div class="mt-10 bg-blue-50 border border-blue-200 rounded-2xl p-8">

    <h3 class="text-2xl font-bold text-blue-800 mb-5">

        💡 Recommendation

    </h3>

    @php

        $score1 = $country1->riskScore->total_score ?? 0;
        $score2 = $country2->riskScore->total_score ?? 0;

    @endphp

    @if($score1 < $score2)

        <div class="space-y-3">

            <p>

                ✅ <b>{{ $country1->name }}</b> memiliki Total Supply Chain Risk lebih rendah.

            </p>

            <p>

                📦 Negara ini lebih direkomendasikan sebagai mitra perdagangan karena memiliki tingkat risiko rantai pasok yang lebih kecil.

            </p>

            <p>

                📈 Berdasarkan data cuaca, ekonomi, pelabuhan, dan berita, {{ $country1->name }} menunjukkan kondisi yang relatif lebih stabil.

            </p>

        </div>

    @elseif($score2 < $score1)

        <div class="space-y-3">

            <p>

                ✅ <b>{{ $country2->name }}</b> memiliki Total Supply Chain Risk lebih rendah.

            </p>

            <p>

                📦 Negara ini lebih direkomendasikan sebagai mitra perdagangan karena memiliki tingkat risiko rantai pasok yang lebih kecil.

            </p>

            <p>

                📈 Berdasarkan data cuaca, ekonomi, pelabuhan, dan berita, {{ $country2->name }} menunjukkan kondisi yang relatif lebih stabil.

            </p>

        </div>

    @else

        <div>

            Kedua negara memiliki tingkat risiko yang hampir sama sehingga dapat dipilih sesuai kebutuhan bisnis.

        </div>

    @endif

</div>

@endif

</div>

@endsection


@push('scripts')

@if(isset($country1))

<script>

const ctx=document.getElementById('compareChart');

new Chart(ctx,{

type:'bar',

data:{

labels:[
'Weather',
'Economy',
'News',
'Port'
],

datasets:[

{

label:'{{ $country1->name }}',

data:[

{{ $country1->riskScore->weather_score ?? 0 }},
{{ $country1->riskScore->economy_score ?? 0 }},
{{ $country1->riskScore->news_score ?? 0 }},
{{ $country1->riskScore->port_score ?? 0 }}

]

},

{

label:'{{ $country2->name }}',

data:[

{{ $country2->riskScore->weather_score ?? 0 }},
{{ $country2->riskScore->economy_score ?? 0 }},
{{ $country2->riskScore->news_score ?? 0 }},
{{ $country2->riskScore->port_score ?? 0 }}

]

}

]

},

options:{

responsive:true,

plugins:{

legend:{

position:'top'

}

},

scales:{

y:{

beginAtZero:true,

max:100

}

}

}

});

</script>

@endif

@endpush
