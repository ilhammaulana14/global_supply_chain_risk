@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">

    <h2 class="text-3xl font-bold text-gray-800 mb-6">

        ✏ Edit User

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

    <form
        action="{{ route('admin.users.update',$user) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="mb-5">

            <label class="font-semibold">

                Nama

            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name',$user->name) }}"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">

                Email

            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email',$user->email) }}"
                class="w-full border rounded-lg p-3 mt-2">

        </div>

        <div class="mb-5">

            <label class="font-semibold">

                Password Baru

            </label>

            <input
                type="password"
                name="password"
                class="w-full border rounded-lg p-3 mt-2">

            <small class="text-gray-500">

                Kosongkan jika tidak ingin mengubah password.

            </small>

        </div>

        <div class="mb-5">

            <label class="font-semibold">

                Role

            </label>

            <select
                name="role"
                class="w-full border rounded-lg p-3 mt-2">

                <option
                    value="user"
                    {{ $user->role=='user' ? 'selected' : '' }}>

                    User

                </option>

                <option
                    value="admin"
                    {{ $user->role=='admin' ? 'selected' : '' }}>

                    Admin

                </option>

            </select>

        </div>

        <div class="flex gap-3">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                Update

            </button>

            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">

                Kembali

            </a>

        </div>

    </form>

</div>

@endsection
