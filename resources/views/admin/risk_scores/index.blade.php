@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-5 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                📊 Supply Chain Risk Score
            </h2>

            <p class="text-gray-500 mt-2">
                Overall supply chain risk analysis for each country
            </p>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Countries</p>
            <h2 class="text-4xl font-bold mt-2">
                {{ $totalCountries }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Risk</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $averageRisk }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">High Risk</p>
            <h2 class="text-4xl font-bold text-red-600 mt-2">
                {{ $highRisk }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Medium Risk</p>
            <h2 class="text-4xl font-bold text-yellow-500 mt-2">
                {{ $mediumRisk }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Low Risk</p>
            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $lowRisk }}
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
                    placeholder="Search Country..."
                    class="flex-1 border rounded-xl px-4 py-3">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

                    Search

                </button>

            </form>

            <a
                href="{{ route('risk.generate') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                ⚡ Generate Risk

            </a>

        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-800 text-white">

                <tr>

                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4 text-left">Country</th>
                    <th class="px-5 py-4 text-center">Weather</th>
                    <th class="px-5 py-4 text-center">Port</th>
                    <th class="px-5 py-4 text-center">Economy</th>
                    <th class="px-5 py-4 text-center">News</th>
                    <th class="px-5 py-4 text-center">Total</th>
                    <th class="px-5 py-4 text-center">Risk</th>

                </tr>

            </thead>

            <tbody>

            @forelse($scores as $score)

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center">
                        {{ $scores->firstItem() + $loop->index }}
                    </td>

                    <td class="px-5 py-4 font-semibold">
                        {{ $score->country->name }}
                    </td>

                    <td class="text-center">
                        {{ $score->weather_score }}
                    </td>

                    <td class="text-center">
                        {{ $score->port_score }}
                    </td>

                    <td class="text-center">
                        {{ $score->economy_score }}
                    </td>

                    <td class="text-center">
                        {{ $score->news_score }}
                    </td>

                    <td class="px-5 py-4">

                        <div class="w-full bg-gray-200 rounded-full h-3">

                            <div
                                class="h-3 rounded-full

                                @if($score->total_score < 40)

                                    bg-green-500

                                @elseif($score->total_score < 70)

                                    bg-yellow-400

                                @else

                                    bg-red-600

                                @endif"

                                style="width: {{ $score->total_score }}%;">

                            </div>

                        </div>

                        <p class="text-center text-sm mt-2">

                            {{ $score->total_score }}

                        </p>

                    </td>

                    <td class="text-center">

                        @if($score->risk_level=='Low')

                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">
                                🟢 Low
                            </span>

                        @elseif($score->risk_level=='Medium')

                            <span class="bg-yellow-400 px-3 py-1 rounded-full">
                                🟡 Medium
                            </span>

                        @else

                            <span class="bg-red-600 text-white px-3 py-1 rounded-full">
                                🔴 High
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="py-8 text-center text-gray-500">

                        No Risk Score Found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex justify-end">

        {{ $scores->links() }}

    </div>

</div>

@endsection
