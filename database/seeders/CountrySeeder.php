<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/countries.json');

        if (!File::exists($path)) {
            $this->command->error('countries.json tidak ditemukan.');
            return;
        }

        $countries = json_decode(File::get($path), true);

        Country::query()->delete();

        foreach ($countries as $country) {

            Country::updateOrCreate(

                [
                    'code' => $country['iso3'],
                ],

                [

                    'name' => $country['name'],

                    'iso2' => $country['iso2'],

                    'capital' => $country['capital'],

                    'region' => $country['region'],

                    'subregion' => $country['subregion'],

                    'population' => $country['population'],

                    'currency' => $country['currency'],

                    'currency_symbol' => $country['currency_symbol'],

                    'flag' => 'https://flagcdn.com/w320/' . strtolower($country['iso2']) . '.png',

                    'latitude' => $country['latitude'],

                    'longitude' => $country['longitude'],

                ]

            );
        }

        $this->command->info('===========================');
        $this->command->info('Import Countries Berhasil');
        $this->command->info('Total : '.Country::count());
        $this->command->info('===========================');
    }
}
