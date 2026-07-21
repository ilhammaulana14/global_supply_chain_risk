<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateCountryCoordinates extends Command
{
    protected $signature = 'countries:update-coordinates';

    protected $description = 'Update country coordinates from Open Meteo Geocoding';

    public function handle()
    {
        $updated = 0;

        $this->info('Mengambil koordinat negara...');

        foreach (Country::all() as $country) {

            $response = Http::timeout(20)
                ->get('https://geocoding-api.open-meteo.com/v1/search',[
                    'name'=>$country->name,
                    'count'=>1,
                    'language'=>'en',
                    'format'=>'json'
                ]);

            if(!$response->successful()){
                continue;
            }

            $json=$response->json();

            if(empty($json['results'])){
                continue;
            }

            $country->update([

                'latitude'=>$json['results'][0]['latitude'],
                'longitude'=>$json['results'][0]['longitude'],

            ]);

            $updated++;

            $this->line("✔ ".$country->name);

            usleep(100000);

        }

        $this->newLine();

        $this->info("Selesai");

        $this->info("Berhasil : ".$updated);
    }
}
