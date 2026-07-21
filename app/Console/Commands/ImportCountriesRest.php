<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class ImportCountriesRest extends Command
{
    protected $signature = 'countries:coordinates';

    protected $description = 'Update country coordinates from REST Countries API';

    public function handle()
    {
        $this->info('Mengambil koordinat negara...');

        $response = Http::timeout(60)
            ->get('https://restcountries.com/v3.1/all?fields=name,cca3,latlng');

        if (!$response->successful()) {

            $this->error('API gagal diakses.');

            return;
        }

        $apiCountries = collect($response->json());
        $this->info('Jumlah data API : '.$apiCountries->count());

dd(
    $apiCountries->firstWhere('cca3','IDN'),
    $apiCountries->firstWhere('cca3','BGD'),
    $apiCountries->firstWhere('cca3','BEL')
);

        $updated = 0;

        foreach (Country::all() as $country) {

            // Cari berdasarkan kode ISO3
            $api = $apiCountries->first(function ($item) use ($country) {

                return isset($item['cca3'])
                    && strtoupper($item['cca3']) == strtoupper($country->code);

            });

            if (!$api) {
                continue;
            }

            if (!isset($api['latlng'][0])) {
                continue;
            }

            $country->update([

                'latitude' => $api['latlng'][0],
                'longitude' => $api['latlng'][1],

            ]);

            $updated++;
        }

        $this->newLine();

        $this->info("Koordinat berhasil diperbarui.");
        $this->line("Data diproses : {$updated}");
        $this->line("Total Country : ".Country::count());
    }
}
