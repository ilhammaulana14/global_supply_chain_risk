<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of countries.
     */
    public function index(Request $request)
    {
        $query = Country::query();

        // ==========================
        // Search
        // ==========================
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('currency', 'like', "%{$search}%");

            });

        }

        // ==========================
        // Filter Region
        // ==========================
        if ($request->filled('region')) {

            $query->where('region', $request->region);

        }

        // ==========================
        // Countries
        // ==========================
        $countries = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // ==========================
        // Region List
        // ==========================
        $regions = Country::whereNotNull('region')
            ->where('region', '!=', '')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');

        // ==========================
        // Statistics
        // ==========================
        $totalCountries = Country::count();

        return view(
            'admin.countries.index',
            compact(
                'countries',
                'regions',
                'totalCountries'
            )
        );
    }

    /**
     * Display country detail.
     */
    public function show(Country $country)
    {
        $country->load([

            'weatherLog',

            'economicData',

            'ports',

            'news',

            'riskScore'

        ]);

        return view(
            'admin.countries.show',
            compact('country')
        );
    }
}
