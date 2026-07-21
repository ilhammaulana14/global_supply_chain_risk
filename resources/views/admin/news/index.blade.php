@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                📰 News Monitoring
            </h2>

            <p class="text-gray-500 mt-2">
                Monitor global news related to supply chain risk
            </p>

        </div>

    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Total News
            </p>

            <h2 class="text-4xl font-bold text-blue-600 mt-2">
                {{ $totalNews }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Today
            </p>

            <h2 class="text-4xl font-bold text-green-600 mt-2">
                {{ $todayNews }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Sources
            </p>

            <h2 class="text-4xl font-bold text-orange-500 mt-2">
                {{ $totalSources }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow p-6">

            <p class="text-gray-500">
                Latest Update
            </p>

            <h2 class="text-lg font-bold text-red-500 mt-3">

                {{ $latestDate ? \Carbon\Carbon::parse($latestDate)->format('d M Y') : '-' }}

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
                    placeholder="Search title, country or source..."
                    class="flex-1 border rounded-xl px-4 py-3">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl">

                    Search

                </button>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-800 text-white">

                <tr>

                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4 text-left">Country</th>
                    <th class="px-5 py-4 text-left">Title</th>
                    <th class="px-5 py-4 text-center">Source</th>
                    <th class="px-5 py-4 text-center">Published</th>
                    <th class="px-5 py-4 text-center">Risk</th>

                </tr>

            </thead>

            <tbody>

            @forelse($news as $item)

                @php

                    $title = strtolower($item->title);

                    if(
                        str_contains($title,'flood') ||
                        str_contains($title,'earthquake') ||
                        str_contains($title,'war') ||
                        str_contains($title,'strike')
                    ){

                        $risk='High';

                    }

                    elseif(
                        str_contains($title,'congestion') ||
                        str_contains($title,'delay')
                    ){

                        $risk='Medium';

                    }

                    else{

                        $risk='Low';

                    }

                @endphp

                <tr class="border-b hover:bg-gray-50">

                    <td class="text-center">

                        {{ $news->firstItem()+$loop->index }}

                    </td>

                    <td class="px-5 py-4">

                        {{ $item->country->name ?? '-' }}

                    </td>

                    <td class="px-5 py-4 font-semibold">

                        {{ $item->title }}

                    </td>

                    <td class="text-center">

                        {{ $item->source }}

                    </td>

                    <td class="text-center">

                        {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }}

                    </td>

                    <td class="text-center">

                        @if($risk=="High")

                            <span class="bg-red-600 text-white px-3 py-1 rounded-full">
                                High
                            </span>

                        @elseif($risk=="Medium")

                            <span class="bg-yellow-400 px-3 py-1 rounded-full">
                                Medium
                            </span>

                        @else

                            <span class="bg-green-600 text-white px-3 py-1 rounded-full">
                                Low
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="py-8 text-center text-gray-500">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="flex justify-end">

        {{ $news->links() }}

    </div>

</div>

@endsection
