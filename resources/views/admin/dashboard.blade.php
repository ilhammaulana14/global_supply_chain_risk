@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-8">

    📊 Admin Dashboard

</h1>

<div class="grid grid-cols-4 gap-6">

    <div class="bg-blue-600 text-white rounded-xl p-6">

        <h3>Total User</h3>

        <p class="text-4xl font-bold">

            {{ $totalUsers }}

        </p>

    </div>

    <div class="bg-green-600 text-white rounded-xl p-6">

        <h3>Total Negara</h3>

        <p class="text-4xl font-bold">

            {{ $totalCountries }}

        </p>

    </div>

    <div class="bg-orange-500 text-white rounded-xl p-6">

        <h3>Total Pelabuhan</h3>

        <p class="text-4xl font-bold">

            {{ $totalPorts }}

        </p>

    </div>

</div>

@endsection
