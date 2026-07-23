<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Country::with('riskScore')->orderBy('name');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $countries = $query->paginate(20)->withQueryString();

        return view('countries.index', compact('countries'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $country->load([
            'weatherLog',
            'economicData',
            'ports',
            'news',
            'riskScore',
        ]);

        return view(
            'admin.countries.show',
            compact('country')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(string $id)
    {
        //
    }
}
