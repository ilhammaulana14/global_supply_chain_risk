@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-xl shadow-lg p-8">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h2 class="text-3xl font-bold text-gray-800">

                👥 User Management

            </h2>

            <p class="text-gray-500">

                Kelola akun pengguna sistem SCRI.

            </p>

        </div>

        <a href="{{ route('admin.users.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">

            + Tambah User

        </a>

    </div>

    @if(session('success'))

    <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded mb-6">

        {{ session('success') }}

    </div>

    @endif

    @if(session('error'))

    <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded mb-6">

        {{ session('error') }}

    </div>

    @endif

    <form method="GET">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="w-full border rounded-lg p-3 mb-6">

    </form>

    <div class="overflow-x-auto">

        <table class="w-full border">

            <thead class="bg-blue-600 text-white">

                <tr>

                    <th class="p-3">No</th>

                    <th class="p-3">Nama</th>

                    <th class="p-3">Email</th>

                    <th class="p-3">Role</th>

                    <th class="p-3">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr class="border">

                    <td class="p-3">

                        {{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}

                    </td>

                    <td class="p-3">

                        {{ $user->name }}

                    </td>

                    <td class="p-3">

                        {{ $user->email }}

                    </td>

                    <td class="p-3">

                        @if($user->role=='admin')

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded">

                                Admin

                            </span>

                        @else

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded">

                                User

                            </span>

                        @endif

                    </td>

                    <td class="p-3 flex gap-2">

                        <a href="{{ route('admin.users.edit',$user) }}"
                           class="bg-yellow-500 text-white px-3 py-2 rounded">

                            Edit

                        </a>

                        <form
                            action="{{ route('admin.users.destroy',$user) }}"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus user ini?')"
                                class="bg-red-600 text-white px-3 py-2 rounded">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center p-5">

                        Tidak ada data.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">

        {{ $users->links() }}

    </div>

</div>

@endsection
