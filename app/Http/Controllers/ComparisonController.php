<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view('comparison.index', compact('countries'));
    }

    public function compare(Request $request)
{
    $request->validate([
        'country1' => 'required|exists:countries,id',
        'country2' => 'required|exists:countries,id|different:country1',
    ]);

    $countries = Country::orderBy('name')->get();

    $country1 = Country::with([
        'weatherLog',
        'economicData',
        'riskScore'
    ])->findOrFail($request->country1);

    $country2 = Country::with([
        'weatherLog',
        'economicData',
        'riskScore'
    ])->findOrFail($request->country2);

    return view('comparison.index', compact(
        'countries',
        'country1',
        'country2'
    ));
}
}
