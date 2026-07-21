<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EconomicData;
use Illuminate\Http\Request;

class EconomyController extends Controller
{
    public function index(Request $request)
    {
        $query = EconomicData::with('country');

        // ==========================
        // Search
        // ==========================

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->whereHas('country', function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");

            });

        }

        // ==========================
        // Data
        // ==========================

        $economies = $query
            ->orderByDesc('year')
            ->orderBy('country_id')
            ->paginate(10)
            ->withQueryString();

        // ==========================
        // Statistik
        // ==========================

        $totalCountries = EconomicData::count();

        $averageGDP = round(
            EconomicData::avg('gdp') ?? 0,
            2
        );

        $averageInflation = round(
            EconomicData::avg('inflation') ?? 0,
            2
        );

        $averageExports = round(
            EconomicData::avg('exports') ?? 0,
            2
        );

        $averageImports = round(
            EconomicData::avg('imports') ?? 0,
            2
        );

        return view('admin.economy.index', [

            'economies'         => $economies,

            'totalCountries'    => $totalCountries,

            'averageGDP'        => $averageGDP,

            'averageInflation'  => $averageInflation,

            'averageExports'    => $averageExports,

            'averageImports'    => $averageImports,

        ]);
    }

    /**
     * Generate dummy economy data
     */
    public function import()
    {
        foreach (Country::all() as $country) {

            EconomicData::updateOrCreate(

                [
                    'country_id' => $country->id,
                    'year'       => 2025,
                ],

                [
                    'gdp'         => rand(1000, 50000),
                    'inflation'   => rand(1, 15),
                    'exports'     => rand(500, 30000),
                    'imports'     => rand(500, 30000),
                ]

            );

        }

        return redirect()
            ->route('economy.index')
            ->with(
                'success',
                'Economic data berhasil diperbarui.'
            );
    }
}
