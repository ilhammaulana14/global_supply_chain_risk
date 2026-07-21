@extends('layouts.admin')

@section('content')

<div class="bg-white rounded-xl shadow p-8">

    <div class="flex justify-between items-center mb-6">

        <div>

            <h1 class="text-4xl font-bold">

                🚢 Port Dataset

            </h1>

            <p class="text-gray-500">

                Kelola dataset pelabuhan.

            </p>

        </div>

        <a href="{{ route('admin.ports.create') }}"
           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">

            + Tambah Port

        </a>

    </div>


    @if(session('success'))

        <div class="mb-5 bg-green-100 text-green-700 px-4 py-3 rounded">

            {{ session('success') }}

        </div>

    @endif


    <form method="GET"
          class="mb-5">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama pelabuhan..."
            class="w-full border rounded-lg px-4 py-3">

    </form>


    <table class="w-full border">

        <thead class="bg-blue-600 text-white">

        <tr>

            <th class="p-3">No</th>

            <th>Port</th>

            <th>Code</th>

            <th>Country</th>

            <th>Congestion</th>

            <th width="180">

                Action

            </th>

        </tr>

        </thead>

        <tbody>

        @forelse($ports as $port)

            <tr class="border-b hover:bg-gray-50">

                <td class="p-3">

                    {{ $loop->iteration + ($ports->firstItem()-1) }}

                </td>

                <td>

                    {{ $port->name }}

                </td>

                <td>

                    {{ $port->code }}

                </td>

                <td>

                    {{ $port->country->name }}

                </td>

                <td>

                    {{ $port->congestion_level }} %

                </td>

                <td>

                    <div class="flex gap-2">

                        <a href="{{ route('admin.ports.edit',$port) }}"
                           class="bg-yellow-500 text-white px-4 py-2 rounded">

                            Edit

                        </a>

                        <form action="{{ route('admin.ports.destroy',$port) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Hapus port ini?')"
                                class="bg-red-600 text-white px-4 py-2 rounded">

                                Delete

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6"
                    class="text-center py-6">

                    Tidak ada data.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="mt-6">

        {{ $ports->links() }}

    </div>

</div>

@endsection
