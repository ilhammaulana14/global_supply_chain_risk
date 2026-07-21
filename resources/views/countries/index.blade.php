@extends('layouts.app')

@section('content')

<h2 class="text-3xl font-bold mb-8">
    🌍 Countries
</h2>

<div class="bg-white rounded-xl shadow p-6">

    <table class="table-auto w-full">

        <thead class="border-b">

        <tr>

            <th class="text-left py-3">Country</th>
            <th>Risk Score</th>
            <th>Risk Level</th>
            <th>Latitude</th>
            <th>Longitude</th>

        </tr>

        </thead>

        <tbody>

        @foreach($countries as $country)

        <tr class="border-b hover:bg-gray-50">

            <td class="py-3">
                {{ $country->name }}
            </td>

            <td class="text-center">
                {{ $country->riskScore->total_score ?? '-' }}
            </td>

            <td class="text-center">

                @php
                    $level = $country->riskScore->risk_level ?? '-';
                @endphp

                @if($level=='High')
                    <span class="text-red-600 font-bold">
                        High
                    </span>

                @elseif($level=='Medium')

                    <span class="text-yellow-500 font-bold">
                        Medium
                    </span>

                @elseif($level=='Low')

                    <span class="text-green-600 font-bold">
                        Low
                    </span>

                @else

                    -

                @endif

            </td>

            <td class="text-center">
                {{ $country->latitude }}
            </td>

            <td class="text-center">
                {{ $country->longitude }}
            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

    <div class="mt-6">
        {{ $countries->links() }}
    </div>

</div>

@endsection
