<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * Display ports.
     */
    public function index(Request $request)
    {
        $query = Port::with('country');

        // ==========================
        // Search
        // ==========================
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

        // ==========================
        // Table
        // ==========================
        $ports = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // ==========================
        // Map
        // ==========================
        $mapPorts = Port::with('country')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->orderBy('name')
            ->get();

        // ==========================
        // Statistics
        // ==========================
        $totalPorts = Port::count();

        $averageCongestion = round(
            Port::avg('congestion_level') ?? 0,
            1
        );

        $safePorts = Port::where('congestion_level', '<', 40)->count();

        $warningPorts = Port::whereBetween(
            'congestion_level',
            [40, 70]
        )->count();

        $criticalPorts = Port::where(
            'congestion_level',
            '>',
            70
        )->count();

        return view('admin.ports.index', compact(
            'ports',
            'mapPorts',
            'totalPorts',
            'averageCongestion',
            'safePorts',
            'warningPorts',
            'criticalPorts'
        ));
    }

    /**
     * Generate Port Data
     */
    public function import()
    {
        $countries = Country::all();

        foreach ($countries as $country) {

            Port::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [
                    'name' => 'Port of ' . $country->name,

                    'code' => strtoupper($country->code) . '-PORT',

                    'latitude' => $country->latitude,

                    'longitude' => $country->longitude,

                    'congestion_level' => rand(15, 90),

                ]

            );

        }

        return redirect()
            ->route('ports.index')
            ->with('success', '249 Port berhasil dibuat.');
    }
}
