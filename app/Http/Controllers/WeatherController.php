<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\WeatherLog;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        $countries = Country::with('weatherLog')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.weather.index', compact('countries'));
    }

    public function update($id)
    {
        $country = Country::findOrFail($id);

        // Pastikan koordinat tersedia
        if (
            is_null($country->latitude) ||
            is_null($country->longitude)
        ) {
            return back()->with(
                'error',
                'Koordinat negara tidak tersedia.'
            );
        }

        try {

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
                return back()->with(
                    'error',
                    'Gagal mengambil data cuaca dari API.'
                );
            }

            $weather = $response->json();

            $temperature = $weather['current']['temperature_2m'] ?? 0;
            $wind        = $weather['current']['wind_speed_10m'] ?? 0;
            $rain        = $weather['daily']['precipitation_sum'][0] ?? 0;

            // Hitung Storm Risk
            if ($wind >= 50 || $rain >= 40) {
                $stormRisk = 3;
            } elseif ($wind >= 25 || $rain >= 20) {
                $stormRisk = 2;
            } elseif ($wind >= 15 || $rain >= 10) {
                $stormRisk = 1;
            } else {
                $stormRisk = 0;
            }

            WeatherLog::updateOrCreate(

                [
                    'country_id'  => $country->id,
                    'weather_date'=> now()->toDateString(),
                ],

                [
                    'temperature' => $temperature,
                    'rainfall'    => $rain,
                    'wind_speed'  => $wind,
                    'storm_risk'  => $stormRisk,
                ]

            );

            return back()->with(
                'success',
                'Data cuaca berhasil diperbarui.'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                'Terjadi kesalahan : '.$e->getMessage()
            );

        }
    }
}
