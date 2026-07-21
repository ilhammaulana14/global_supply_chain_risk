@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">
        ➕ Tambah User
    </h2>

    @if ($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-5">

            <ul class="list-disc ml-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">

        @csrf

        <div class="mb-5">

            <label class="font-semibold">Nama</label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Password</label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Konfirmasi Password</label>

            <input
                type="password"
                name="password_confirmation"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">Role</label>

            <select
                name="role"
                class="w-full border rounded-lg p-3 mt-2">

                <option value="user">User</option>

                <option value="admin">Admin</option>

            </select>

        </div>

        <div class="flex gap-3">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                Simpan

            </button>

            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection
