<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class ImportCountries extends Command
{
    protected $signature = 'countries:import';

    protected $description = 'Import Countries From REST Countries API';

    public function handle()
    {
        $this->info('Mengambil data negara...');

        $response = Http::timeout(60)
            ->get('https://restcountries.com/v3.1/all?fields=name,cca3,capital,region,subregion,population,currencies,flags,latlng');

        if (!$response->successful()) {

            $this->error('API gagal.');

            return;
        }

        $countries = $response->json();

        $this->info('Jumlah API : '.count($countries));

        foreach ($countries as $item) {

            $currency = null;
            $symbol = null;

            if(isset($item['currencies'])){

                $key = array_key_first($item['currencies']);

                $currency = $key;

                $symbol = $item['currencies'][$key]['symbol'] ?? null;
            }

            Country::updateOrCreate(

                [
                    'code'=>$item['cca3']
                ],

                [

                    'name'=>$item['name']['common'] ?? '',

                    'capital'=>$item['capital'][0] ?? '-',

                    'region'=>$item['region'] ?? '-',

                    'subregion'=>$item['subregion'] ?? '-',

                    'population'=>$item['population'] ?? 0,

                    'currency'=>$currency,

                    'currency_symbol'=>$symbol,

                    'flag'=>$item['flags']['png'] ?? '',

                    'latitude'=>$item['latlng'][0] ?? null,

                    'longitude'=>$item['latlng'][1] ?? null,

                ]

            );

        }

        $this->info('=============================');

        $this->info('Import selesai');

        $this->info('Total Negara : '.Country::count());

        $this->info('=============================');

    }
}
