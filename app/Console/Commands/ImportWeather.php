<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\WeatherLog;

class ImportWeather extends Command
{
    protected $signature = 'weather:import';

    protected $description = 'Generate dummy weather data for all countries';

    public function handle()
    {
        $this->info('Generating weather data...');

        $countries = Country::all();

        foreach ($countries as $country) {

            WeatherLog::updateOrCreate(

                [
                    'country_id'   => $country->id,
                    'weather_date' => now()->toDateString(),
                ],

                [
                    'temperature' => rand(18, 38),
                    'rainfall'    => rand(0, 150),
                    'wind_speed'  => rand(5, 50),
                    'storm_risk'  => rand(0, 100),
                ]
            );
        }

        $this->info('============================');
        $this->info('Weather data generated');
        $this->info('Total country : '.$countries->count());
        $this->info('============================');

        return Command::SUCCESS;
    }
}
