<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\EconomicData;
use App\Models\News;
use App\Models\Port;
use App\Models\RiskScore;
use App\Models\WeatherLog;
use Illuminate\Http\Request;

class RiskScoreController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskScore::with('country');

        // Search
        if ($request->filled('search')) {

            $query->whereHas('country', function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%');

            });

        }

        $scores = $query
            ->orderByDesc('total_score')
            ->paginate(10)
            ->withQueryString();

        return view('admin.risk_scores.index', [

            'scores'           => $scores,

            'totalCountries'   => RiskScore::count(),

            'averageRisk'      => round(RiskScore::avg('total_score'), 1),

            'highRisk'         => RiskScore::where('risk_level', 'High')->count(),

            'mediumRisk'       => RiskScore::where('risk_level', 'Medium')->count(),

            'lowRisk'          => RiskScore::where('risk_level', 'Low')->count(),

        ]);
    }

    public function generate()
    {
        $countries = Country::all();

        foreach ($countries as $country) {

            /*
            |--------------------------------------------------------------------------
            | WEATHER
            |--------------------------------------------------------------------------
            */

            $weather = WeatherLog::where('country_id', $country->id)
                ->latest()
                ->first();

            $weatherScore = match ($weather->storm_risk ?? 0) {

                3 => 100,
                2 => 70,
                1 => 40,
                default => 10

            };

            /*
            |--------------------------------------------------------------------------
            | PORT
            |--------------------------------------------------------------------------
            */

            $averageCongestion = Port::where('country_id', $country->id)
                ->avg('congestion_level');

            $portScore = round($averageCongestion ?? 0);

            /*
            |--------------------------------------------------------------------------
            | ECONOMY
            |--------------------------------------------------------------------------
            */

            $economy = EconomicData::where('country_id', $country->id)
                ->latest('year')
                ->first();

            $inflation = $economy->inflation ?? 0;

            if ($inflation >= 8) {

                $economyScore = 100;

            } elseif ($inflation >= 5) {

                $economyScore = 75;

            } elseif ($inflation >= 3) {

                $economyScore = 50;

            } else {

                $economyScore = 20;

            }

            /*
            |--------------------------------------------------------------------------
            | NEWS
            |--------------------------------------------------------------------------
            */

            $newsCount = News::where('country_id', $country->id)->count();

            if ($newsCount >= 5) {

                $newsScore = 100;

            } elseif ($newsCount >= 3) {

                $newsScore = 80;

            } elseif ($newsCount >= 1) {

                $newsScore = 40;

            } else {

                $newsScore = 10;

            }

            /*
            |--------------------------------------------------------------------------
            | FINAL SCORE
            |--------------------------------------------------------------------------
            */

            $total = round(

                ($weatherScore * 0.35) +

                ($portScore * 0.30) +

                ($economyScore * 0.25) +

                ($newsScore * 0.10)

            );

            /*
            |--------------------------------------------------------------------------
            | RISK LEVEL
            |--------------------------------------------------------------------------
            */

            if ($total >= 70) {

                $risk = 'High';

            } elseif ($total >= 45) {

                $risk = 'Medium';

            } else {

                $risk = 'Low';

            }

            /*
            |--------------------------------------------------------------------------
            | SAVE
            |--------------------------------------------------------------------------
            */

            RiskScore::updateOrCreate(

                [
                    'country_id' => $country->id
                ],

                [

                    'weather_score' => $weatherScore,

                    'port_score' => $portScore,

                    'economy_score' => $economyScore,

                    'news_score' => $newsScore,

                    'total_score' => $total,

                    'risk_level' => $risk

                ]

            );
        }

        return redirect()
            ->route('risk-scores.index')
            ->with(
                'success',
                'Risk Score berhasil dihitung.'
            );
    }
}
