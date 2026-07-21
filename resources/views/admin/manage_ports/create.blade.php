@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-xl shadow p-8 max-w-4xl">

    <h1 class="text-4xl font-bold mb-2">
        🚢 Tambah Port
    </h1>

    <p class="text-gray-500 mb-8">
        Tambahkan dataset pelabuhan baru.
    </p>

    <form action="{{ route('admin.ports.store') }}"
          method="POST">

        @csrf

        <div class="grid grid-cols-2 gap-6">

            {{-- Country --}}
            <div>
                <label class="font-semibold">
                    Negara
                </label>

                <select
                    name="country_id"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

                    <option value="">
                        -- Pilih Negara --
                    </option>

                    @foreach($countries as $country)

                        <option
                            value="{{ $country->id }}"
                            {{ old('country_id')==$country->id ? 'selected' : '' }}>

                            {{ $country->name }}

                        </option>

                    @endforeach

                </select>

                @error('country_id')

                    <p class="text-red-500 text-sm mt-1">

                        {{ $message }}

                    </p>

                @enderror

            </div>


            {{-- Code --}}
            <div>

                <label class="font-semibold">

                    Kode Port

                </label>

                <input
                    type="text"
                    name="code"
                    value="{{ old('code') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

                @error('code')

                    <p class="text-red-500 text-sm mt-1">

                        {{ $message }}

                    </p>

                @enderror

            </div>


            {{-- Name --}}
            <div class="col-span-2">

                <label class="font-semibold">

                    Nama Pelabuhan

                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

                @error('name')

                    <p class="text-red-500 text-sm mt-1">

                        {{ $message }}

                    </p>

                @enderror

            </div>


            {{-- Latitude --}}
            <div>

                <label class="font-semibold">

                    Latitude

                </label>

                <input
                    type="number"
                    step="any"
                    name="latitude"
                    value="{{ old('latitude') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

            </div>


            {{-- Longitude --}}
            <div>

                <label class="font-semibold">

                    Longitude

                </label>

                <input
                    type="number"
                    step="any"
                    name="longitude"
                    value="{{ old('longitude') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

            </div>


            {{-- Congestion --}}
            <div class="col-span-2">

                <label class="font-semibold">

                    Tingkat Kemacetan (%)

                </label>

                <input
                    type="number"
                    min="0"
                    max="100"
                    name="congestion_level"
                    value="{{ old('congestion_level') }}"
                    class="w-full border rounded-lg px-4 py-3 mt-2">

                @error('congestion_level')

                    <p class="text-red-500 text-sm mt-1">

                        {{ $message }}

                    </p>

                @enderror

            </div>

        </div>


        <div class="mt-8 flex gap-3">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                Simpan

            </button>

            <a href="{{ route('admin.ports.index') }}"
               class="bg-gray-300 hover:bg-gray-400 px-6 py-3 rounded-lg">

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection
