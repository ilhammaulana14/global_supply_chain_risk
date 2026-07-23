<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Country;
use App\Models\Port;
use App\Models\News;


class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $latestUsers = User::latest()->take(5)->get();
        $totalCountries = Country::count();
        $totalWeather = Country::has('weatherLog')->count();
        $totalPorts = Port::count();
        $totalEconomy = \App\Models\EconomicData::count();
        $totalNews = News::count();
        $highRisk = \App\Models\RiskScore::where('risk_level', 'High')->count();
        $mediumRisk = \App\Models\RiskScore::where('risk_level', 'Medium')->count();
        $lowRisk = \App\Models\RiskScore::where('risk_level', 'Low')->count();
        $averageRisk = round(\App\Models\RiskScore::avg('total_score') ?? 0, 1);

        $averageTemperature = round(\App\Models\WeatherLog::avg('temperature') ?? 0, 1);
        $averageRainfall = round(\App\Models\WeatherLog::avg('rainfall') ?? 0, 1);
        $stormCountry = \App\Models\WeatherLog::where('storm_risk', 3)->count();
        $averageCongestion = round(Port::avg('congestion_level') ?? 0, 1);
        $criticalPorts = Port::where('congestion_level', '>', 70)->count();
        $averageGDP = round(\App\Models\EconomicData::avg('gdp') ?? 0, 2);
        $averageInflation = round(\App\Models\EconomicData::avg('inflation') ?? 0, 2);

        $topRisk = \App\Models\RiskScore::with('country')
            ->orderByDesc('total_score')
            ->take(10)
            ->get();

        $latestNews = News::with('country')
            ->latest('published_at')
            ->take(5)
            ->get();

        $mapCountries = Country::with('riskScore')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $chart = [
            'labels' => ['High', 'Medium', 'Low'],
            'data' => [$highRisk, $mediumRisk, $lowRisk]
        ];

        $barChart = [
            'labels' => $topRisk->pluck('country.name'),
            'scores' => $topRisk->pluck('total_score')
        ];

        $favoriteCountries = auth()->user()
            ? auth()->user()->favoriteCountries()->with('riskScore', 'weatherLog')->get()
            : collect();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'latestUsers',
            'totalCountries',
            'totalWeather',
            'totalPorts',
            'totalEconomy',
            'totalNews',
            'highRisk',
            'mediumRisk',
            'lowRisk',
            'averageRisk',
            'averageTemperature',
            'averageRainfall',
            'stormCountry',
            'averageCongestion',
            'criticalPorts',
            'averageGDP',
            'averageInflation',
            'topRisk',
            'latestNews',
            'mapCountries',
            'chart',
            'barChart',
            'favoriteCountries'
        ));
    }
}
