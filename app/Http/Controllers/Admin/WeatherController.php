<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\WeatherLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Halaman Weather
     */
    public function index(Request $request)
    {
        $query = Country::with('weatherLog');

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");

            });
        }

        $countries = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.weather.index', [

            'countries'     => $countries,
            'totalCountry'  => Country::count(),
            'avgTemp'       => round(WeatherLog::avg('temperature') ?? 0, 1),
            'avgRain'       => round(WeatherLog::avg('rainfall') ?? 0, 1),
            'stormCount'    => WeatherLog::where('storm_risk', 3)->count(),
            'highestTemp'   => WeatherLog::max('temperature') ?? 0,
            'lowestTemp'    => WeatherLog::min('temperature') ?? 0,

        ]);
    }

    /**
     * Refresh satu negara
     */
    public function update($id)
    {
        $country = Country::findOrFail($id);

        if (
            empty($country->latitude) ||
            empty($country->longitude)
        ) {

            return back()->with(
                'error',
                'Koordinat negara belum tersedia.'
            );

        }

        try {

            $this->updateWeather($country);

            return back()->with(
                'success',
                'Weather berhasil diperbarui.'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );

        }
    }

    /**
     * Refresh seluruh negara
     */
    public function refreshAll()
    {
        $countries = Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $updated = 0;

        foreach ($countries as $country) {

            try {

                $this->updateWeather($country);

                $updated++;

                usleep(150000);

            } catch (\Exception $e) {

                continue;

            }

        }

        return redirect()
            ->route('weather.index')
            ->with(
                'success',
                $updated . ' negara berhasil diperbarui.'
            );
    }

    /**
     * Mengambil data cuaca dari Open Meteo
     */
    private function updateWeather(Country $country)
    {
        $response = Http::timeout(30)->get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude'  => $country->latitude,
                'longitude' => $country->longitude,
                'current'   => 'temperature_2m,wind_speed_10m',
                'daily'     => 'precipitation_sum',
                'timezone'  => 'auto',
            ]
        );

        if (!$response->successful()) {

            throw new \Exception('API Open Meteo gagal diakses.');

        }

        $weather = $response->json();

        $temperature = $weather['current']['temperature_2m'] ?? 0;
        $wind        = $weather['current']['wind_speed_10m'] ?? 0;
        $rain        = $weather['daily']['precipitation_sum'][0] ?? 0;

        $stormRisk = 0;

        if ($wind >= 50 || $rain >= 40) {

            $stormRisk = 3;

        } elseif ($wind >= 30 || $rain >= 20) {

            $stormRisk = 2;

        } elseif ($wind >= 15 || $rain >= 10) {

            $stormRisk = 1;

        }

        WeatherLog::updateOrCreate(

            [
                'country_id'   => $country->id,
                'weather_date' => today(),
            ],

            [
                'temperature' => $temperature,
                'rainfall'    => $rain,
                'wind_speed'  => $wind,
                'storm_risk'  => $stormRisk,
            ]

        );
    }
}
