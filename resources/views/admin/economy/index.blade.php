@extends('layouts.app')

@section('content')

@php

function shortNumber($number)
{
    if ($number >= 1000000000000) {
        return number_format($number / 1000000000000,2).' T';
    }

    if ($number >= 1000000000) {
        return number_format($number / 1000000000,2).' B';
    }

    if ($number >= 1000000) {
        return number_format($number / 1000000,2).' M';
    }

    return number_format($number,2);
}

@endphp

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
    <div>

        <h2 class="text-3xl font-bold text-slate-800">
            💰 Economy Monitoring
        </h2>

        <p class="text-gray-500 mt-2">
            Monitor indikator ekonomi setiap negara
        </p>

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
            <p class="text-gray-500">Average GDP</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ shortNumber($averageGDP) }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Inflation</p>
            <h2 class="text-3xl font-bold text-red-500 mt-2">
                {{ $averageInflation }}%
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Export</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ shortNumber($averageExports) }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Average Import</p>
            <h2 class="text-3xl font-bold text-orange-500 mt-2">
                {{ shortNumber($averageImports) }}
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

            <form
                action="{{ route('economy.import') }}"
                method="POST">

                @csrf

                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                    📥 Import Data

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

                <th class="px-5 py-4 text-left">
                    Country
                </th>

                <th class="px-5 py-4 text-center">
                    Year
                </th>

                <th class="px-5 py-4 text-center">
                    GDP
                </th>

                <th class="px-5 py-4 text-center">
                    Inflation
                </th>

                <th class="px-5 py-4 text-center">
                    Export
                </th>

                <th class="px-5 py-4 text-center">
                    Import
                </th>

                <th class="px-5 py-4 text-center">
                    Status
                </th>

            </tr>

            </thead>

            <tbody>

            @forelse($economies as $economy)

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center">

                        {{ $economies->firstItem()+$loop->index }}

                    </td>

                    <td class="px-5 py-4 font-semibold">

                        {{ $economy->country->name }}

                    </td>

                    <td class="text-center">

                        {{ $economy->year }}

                    </td>

                    <td class="text-center font-semibold text-green-600">

                        {{ shortNumber($economy->gdp) }}

                    </td>

                    <td class="px-5 py-4">

                        <div class="w-full bg-gray-200 rounded-full h-3">

                            <div
                                class="bg-red-500 h-3 rounded-full"
                                style="width: {{ min($economy->inflation*7,100) }}%">
                            </div>

                        </div>

                        <p class="text-center text-sm mt-2">

                            {{ $economy->inflation }}%

                        </p>

                    </td>

                    <td class="text-center font-semibold text-blue-600">

                        {{ shortNumber($economy->exports) }}

                    </td>

                    <td class="text-center font-semibold text-orange-500">

                        {{ shortNumber($economy->imports) }}

                    </td>

                    <td class="text-center">

                        @if($economy->inflation < 3)

                            <span class="bg-green-500 text-white px-3 py-1 rounded-full">

                                🟢 Stable

                            </span>

                        @elseif($economy->inflation <= 6)

                            <span class="bg-yellow-400 text-black px-3 py-1 rounded-full">

                                🟡 Moderate

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

                    <td colspan="8"
                        class="py-8 text-center text-gray-500">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex justify-end">

        {{ $economies->links() }}

    </div>

</div>

@endsection
