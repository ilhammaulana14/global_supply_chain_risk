@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">

        <div>
            <h2 class="text-3xl font-bold text-slate-800">
                🌍 Countries
            </h2>

            <p class="text-gray-500 mt-1">
                Manage all countries in the Supply Chain Risk Intelligence System.
            </p>
        </div>

        <div class="bg-blue-600 text-white px-6 py-4 rounded-xl shadow">

            <p class="text-sm">
                Total Countries
            </p>

            <h3 class="text-3xl font-bold">
                {{ $totalCountries }}
            </h3>

        </div>

    </div>

    <!-- Search & Filter -->

    <div class="bg-white rounded-xl shadow p-5">

        <form method="GET"
              action="{{ route('countries.index') }}"
              class="grid md:grid-cols-3 gap-4">

            <!-- Search -->

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="🔍 Search country..."
                class="border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">

            <!-- Region -->

            <select
                name="region"
                class="border rounded-lg px-4 py-3">

                <option value="">
                    All Region
                </option>

                @foreach($regions as $region)

                    <option
                        value="{{ $region }}"
                        {{ request('region')==$region ? 'selected' : '' }}>

                        {{ $region }}

                    </option>

                @endforeach

            </select>

            <!-- Button -->

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-5 py-3">

                Search

            </button>

        </form>

    </div>

    <!-- Table -->

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-800 text-white">

                    <tr>

                        <th class="px-5 py-4 text-left">No</th>

                        <th class="px-5 py-4 text-center">
                            Flag
                        </th>

                        <th class="px-5 py-4">
                            Country
                        </th>

                        <th class="px-5 py-4 text-center">
                            ISO
                        </th>

                        <th class="px-5 py-4 text-center">
                            Region
                        </th>

                        <th class="px-5 py-4 text-center">
                            Currency
                        </th>

                        <th class="px-5 py-4 text-center">
                            Population
                        </th>

                        <th class="px-5 py-4 text-center">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody>

                @forelse($countries as $country)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="px-5 py-4">

                            {{ $countries->firstItem() + $loop->index }}

                        </td>

                        <td class="px-5 py-4 text-center">

                            <img
                                src="{{ $country->flag }}"
                                class="w-12 h-8 mx-auto rounded shadow"
                                alt="flag">

                        </td>

                        <td class="px-5 py-4 font-semibold">

                            {{ $country->name }}

                        </td>

                        <td class="px-5 py-4 text-center">

                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                {{ $country->code }}

                            </span>

                        </td>

                        <td class="px-5 py-4 text-center">

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                {{ $country->region ?: '-' }}

                            </span>

                        </td>

                        <td class="px-5 py-4 text-center">

                            {{ $country->currency ?: '-' }}

                        </td>

                        <td class="px-5 py-4 text-center">

                            {{ number_format($country->population) }}

                        </td>

                        <td class="px-5 py-4 text-center">

                            <a
                                href="{{ route('countries.show',$country->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                Detail

                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-10 text-gray-500">

                            Tidak ada data negara.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- Pagination -->

    <div class="flex justify-end">

        {{ $countries->links() }}

    </div>

</div>

@endsection
