@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex justify-between items-start">

        <div class="flex items-center gap-5">

            <img
                src="{{ $country->flag }}"
                alt="{{ $country->name }}"
                class="w-24 h-16 rounded-lg shadow border object-cover">

            <div>

                <h1 class="text-4xl font-bold text-slate-800">

                    {{ $country->name }}

                </h1>

                <p class="text-gray-500 mt-1">

                    Supply Chain Risk Intelligence

                </p>

                @if($country->riskScore)

                    @php

                        $color = match($country->riskScore->risk_level){

                            'High' => 'bg-red-600',

                            'Medium' => 'bg-yellow-500',

                            default => 'bg-green-600'

                        };

                    @endphp

                    <span class="inline-block mt-4 px-5 py-2 rounded-full text-white font-semibold {{ $color }}">

                        {{ strtoupper($country->riskScore->risk_level) }} RISK

                    </span>

                @endif

            </div>

        </div>

        <a href="{{ route('countries.index') }}"
           class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-lg">

            ← Back to Countries

        </a>

    </div>



    {{-- Country Information --}}
    <div class="bg-white rounded-xl shadow p-8">

        <h2 class="text-2xl font-bold mb-8">

            🌍 Country Information

        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div>

                <p class="text-gray-500">

                    Country

                </p>

                <h3 class="font-bold text-xl">

                    {{ $country->name }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500">

                    Country Code

                </p>

                <h3 class="font-bold text-xl">

                    {{ $country->code }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500">

                    Capital

                </p>

                <h3 class="font-bold text-xl">

                    {{ $country->capital ?? '-' }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500">

                    Region

                </p>

                <h3 class="font-bold text-xl">

                    {{ $country->region ?? '-' }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500">

                    Population

                </p>

                <h3 class="font-bold text-xl">

                    {{ number_format($country->population) }}

                </h3>

            </div>

            <div>

                <p class="text-gray-500">

                    Currency

                </p>

                <h3 class="font-bold text-xl">

                    {{ $country->currency ?? '-' }}

                </h3>

            </div>

        </div>

    </div>

        {{-- Weather & Economy --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Weather --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-2xl font-bold mb-6">
                🌤 Weather Information
            </h2>

            @if($country->weatherLog)

                <div class="space-y-5">

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">Temperature</span>
                        <span class="font-bold text-xl">
                            {{ $country->weatherLog->temperature }} °C
                        </span>
                    </div>

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-gray-600">Rainfall</span>
                        <span class="font-bold text-xl">
                            {{ $country->weatherLog->rainfall }} mm
                        </span>
                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-600">
                            Storm Risk
                        </span>

                        @if($country->weatherLog->storm_risk >= 3)

                            <span class="bg-red-500 text-white px-3 py-1 rounded-full">

                                High

                            </span>

                        @elseif($country->weatherLog->storm_risk == 2)

                            <span class="bg-yellow-400 px-3 py-1 rounded-full">

                                Medium

                            </span>

                        @else

                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">

                                Low

                            </span>

                        @endif

                    </div>

                </div>

            @else

                <p class="text-gray-500">

                    No weather information available.

                </p>

            @endif

        </div>



        {{-- Economy --}}
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-2xl font-bold mb-6">

                💰 Economy

            </h2>

            @if($country->economicData)

                <div class="space-y-5">

                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-600">

                            GDP

                        </span>

                        <span class="font-bold">

                            ${{ number_format($country->economicData->gdp,2) }}

                        </span>

                    </div>

                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-600">

                            Inflation

                        </span>

                        <span class="font-bold">

                            {{ $country->economicData->inflation }} %

                        </span>

                    </div>

                    <div class="flex justify-between border-b pb-3">

                        <span class="text-gray-600">

                            Exports

                        </span>

                        <span class="font-bold">

                            ${{ number_format($country->economicData->exports,2) }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-gray-600">

                            Imports

                        </span>

                        <span class="font-bold">

                            ${{ number_format($country->economicData->imports,2) }}

                        </span>

                    </div>

                </div>

            @else

                <p class="text-gray-500">

                    No economy information available.

                </p>

            @endif

        </div>

    </div>



    {{-- Ports --}}
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">

            🚢 Ports

        </h2>

        <table class="w-full">

            <thead>

                <tr class="border-b">

                    <th class="text-left py-3">

                        Port Name

                    </th>

                    <th class="text-center">

                        Congestion

                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($country->ports as $port)

                    <tr class="border-b">

                        <td class="py-4">

                            {{ $port->name }}

                        </td>

                        <td class="text-center">

                            @if($port->congestion_level >= 70)

                                <span class="bg-red-500 text-white px-3 py-1 rounded-full">

                                    {{ $port->congestion_level }} %

                                </span>

                            @elseif($port->congestion_level >= 40)

                                <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">

                                    {{ $port->congestion_level }} %

                                </span>

                            @else

                                <span class="bg-green-500 text-white px-3 py-1 rounded-full">

                                    {{ $port->congestion_level }} %

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="2" class="text-center py-6 text-gray-500">

                            No port data available.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

        {{-- Latest News --}}
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-6">

            📰 Latest News

        </h2>

        @forelse($country->news->take(5) as $item)

            <div class="border-b py-4 last:border-0">

                <div class="flex justify-between items-start">

                    <div>

                        <h4 class="font-bold text-lg">

                            {{ $item->title }}

                        </h4>

                        <p class="text-gray-500 mt-1">

                            {{ $item->source }}

                        </p>

                        <p class="text-sm text-gray-400">

                            {{ optional($item->published_at)->format('d M Y') }}

                        </p>

                    </div>

                    @if($item->url)

                        <a href="{{ $item->url }}"
                           target="_blank"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded">

                            Read

                        </a>

                    @endif

                </div>

            </div>

        @empty

            <div class="text-center py-8 text-gray-500">

                No news available.

            </div>

        @endforelse

    </div>



    {{-- Risk Score --}}
    <div class="bg-white rounded-xl shadow p-6">

        <h2 class="text-2xl font-bold mb-8">

            ⚠ Supply Chain Risk Assessment

        </h2>

        @if($country->riskScore)

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Weather --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        Weather Score

                    </p>

                    <h3 class="text-4xl font-bold text-blue-600 mt-3">

                        {{ $country->riskScore->weather_score }}

                    </h3>

                </div>

                {{-- Port --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        Port Score

                    </p>

                    <h3 class="text-4xl font-bold text-indigo-600 mt-3">

                        {{ $country->riskScore->port_score }}

                    </h3>

                </div>

                {{-- Economy --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        Economy Score

                    </p>

                    <h3 class="text-4xl font-bold text-green-600 mt-3">

                        {{ $country->riskScore->economy_score }}

                    </h3>

                </div>

                {{-- News --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        News Score

                    </p>

                    <h3 class="text-4xl font-bold text-orange-600 mt-3">

                        {{ $country->riskScore->news_score }}

                    </h3>

                </div>

                {{-- Total --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        Total Score

                    </p>

                    <h3 class="text-5xl font-bold text-blue-700 mt-3">

                        {{ $country->riskScore->total_score }}

                    </h3>

                </div>

                {{-- Risk Level --}}
                <div class="border rounded-lg p-5">

                    <p class="text-gray-500">

                        Risk Level

                    </p>

                    <div class="mt-3">

                        @if($country->riskScore->risk_level == 'High')

                            <span class="bg-red-600 text-white px-5 py-2 rounded-full font-bold">

                                HIGH

                            </span>

                        @elseif($country->riskScore->risk_level == 'Medium')

                            <span class="bg-yellow-400 text-black px-5 py-2 rounded-full font-bold">

                                MEDIUM

                            </span>

                        @else

                            <span class="bg-green-600 text-white px-5 py-2 rounded-full font-bold">

                                LOW

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Progress Bar --}}

            <div class="mt-10">

                <div class="flex justify-between mb-2">

                    <span class="font-semibold">

                        Overall Risk Score

                    </span>

                    <span class="font-bold">

                        {{ $country->riskScore->total_score }}/100

                    </span>

                </div>

                <div class="w-full bg-gray-200 rounded-full h-6">

                    <div

                        class="@if($country->riskScore->risk_level=='High')
                                bg-red-600
                               @elseif($country->riskScore->risk_level=='Medium')
                                bg-yellow-500
                               @else
                                bg-green-600
                               @endif
                               h-6 rounded-full"

                        style="width: {{ $country->riskScore->total_score }}%">

                    </div>

                </div>

            </div>

        @else

            <div class="text-center py-10 text-gray-500">

                Risk score not generated.

            </div>

        @endif

    </div>

    </div>

@endsection
