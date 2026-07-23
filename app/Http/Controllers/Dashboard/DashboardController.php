<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\WeatherLog;
use App\Models\Port;
use App\Models\EconomicData;
use App\Models\News;
use App\Models\RiskScore;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================
        // Statistik Utama
        // ==========================

        $totalCountries = Country::count();

       $totalWeather = Country::has('weatherLog')->count();

        $totalPorts = Port::count();

        $totalEconomy = EconomicData::count();

        $totalNews = News::count();

        $highRisk = RiskScore::where('risk_level', 'High')->count();

        // ==========================
        // Weather
        // ==========================

        $averageTemperature = round(
            WeatherLog::avg('temperature') ?? 0,
            1
        );

        $averageRainfall = round(
            WeatherLog::avg('rainfall') ?? 0,
            1
        );

        $stormCountry = WeatherLog::where('storm_risk', 3)->count();

        // ==========================
        // Port
        // ==========================

        $averageCongestion = round(
            Port::avg('congestion_level') ?? 0,
            1
        );

        $criticalPorts = Port::where(
            'congestion_level',
            '>',
            70
        )->count();

        // ==========================
        // Economy
        // ==========================

        $averageGDP = round(
            EconomicData::avg('gdp') ?? 0,
            2
        );

        $averageInflation = round(
            EconomicData::avg('inflation') ?? 0,
            2
        );

        // ==========================
        // Risk Chart
        // ==========================

        $lowRisk = RiskScore::where(
            'risk_level',
            'Low'
        )->count();

        $mediumRisk = RiskScore::where(
            'risk_level',
            'Medium'
        )->count();

        // ==========================
        // Top 10 Risk
        // ==========================

        $topRisk = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->take(10)
            ->get();

        // ==========================
        // Latest News
        // ==========================

        $latestNews = News::with('country')
            ->latest('published_at')
            ->take(5)
            ->get();

        // ==========================
        // Map
        // ==========================

        $mapCountries = Country::with('riskScore')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

            $chart = [
    'labels' => ['High', 'Medium', 'Low'],
    'data' => [
        $highRisk,
        $mediumRisk,
        $lowRisk
    ]
];

        $barChart = [
            'labels' => $topRisk->pluck('country.name'),
            'scores' => $topRisk->pluck('total_score')
        ];

        $favoriteCountries = auth()->user()
            ? auth()->user()->favoriteCountries()->with('riskScore', 'weatherLog')->get()
            : collect();

        return view('dashboard', compact(
            'totalCountries',
            'totalWeather',
            'totalPorts',
            'totalEconomy',
            'totalNews',
            'highRisk',
            'averageTemperature',
            'averageRainfall',
            'stormCountry',
            'averageCongestion',
            'criticalPorts',
            'averageGDP',
            'averageInflation',
            'lowRisk',
            'mediumRisk',
            'topRisk',
            'latestNews',
            'mapCountries',
            'chart',
            'barChart',
            'favoriteCountries'
        ));

    }   // <-- menutup function index()

}       // <-- menutup class DashboardController
