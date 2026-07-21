<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;

class AdminPortController extends Controller
{
    /**
     * Daftar Port
     */
    public function index(Request $request)
    {
        $query = Port::with('country');

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhereHas('country', function ($country) use ($search) {

                        $country->where('name', 'like', "%{$search}%");

                    });

            });

        }

        $ports = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.manage_ports.index',
            compact('ports')
        );
    }

    /**
     * Form Tambah Port
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'admin.manage_ports.create',
            compact('countries')
        );
    }

    /**
     * Simpan Port
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'country_id'        => 'required|exists:countries,id',

            'name'              => 'required|string|max:255',

            'code'              => 'required|string|max:50|unique:ports,code',

            'latitude'          => 'nullable|numeric',

            'longitude'         => 'nullable|numeric',

            'congestion_level'  => 'required|integer|min:0|max:100',

        ]);

        Port::create($validated);

        return redirect()
            ->route('admin.ports.index')
            ->with(
                'success',
                'Port berhasil ditambahkan.'
            );
    }

    /**
     * Form Edit
     */
    public function edit(Port $port)
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'admin.manage_ports.edit',
            compact(
                'port',
                'countries'
            )
        );
    }

    /**
     * Update Port
     */
    public function update(Request $request, Port $port)
    {
        $validated = $request->validate([

            'country_id'        => 'required|exists:countries,id',

            'name'              => 'required|string|max:255',

            'code'              => 'required|string|max:50|unique:ports,code,' . $port->id,

            'latitude'          => 'nullable|numeric',

            'longitude'         => 'nullable|numeric',

            'congestion_level'  => 'required|integer|min:0|max:100',

        ]);

        $port->update($validated);

        return redirect()
            ->route('admin.ports.index')
            ->with(
                'success',
                'Port berhasil diperbarui.'
            );
    }

    /**
     * Hapus Port
     */
    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()
            ->route('admin.ports.index')
            ->with(
                'success',
                'Port berhasil dihapus.'
            );
    }
}
