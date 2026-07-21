<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class ImportCountriesNow extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'countries:import';

    /**
     * Deskripsi command
     */
    protected $description = 'Import countries from CountriesNow API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Mengambil data negara dari API...');

        $response = Http::timeout(60)->get(
            'https://countriesnow.space/api/v0.1/countries/info?returns=currency,flag,iso3'
        );

        if (!$response->successful()) {
            $this->error('Gagal mengambil data dari API.');
            $this->error('Status : ' . $response->status());

            return Command::FAILURE;
        }

        $result = $response->json();

        if (!isset($result['data']) || !is_array($result['data'])) {
            $this->error('Format data API tidak sesuai.');

            return Command::FAILURE;
        }

        $this->info('Jumlah data dari API : ' . count($result['data']));

        $imported = 0;

        foreach ($result['data'] as $country) {

            Country::updateOrCreate(

    [
        'code' => $country['iso3'],
    ],

    [
        'name' => $country['name'],
        'iso2' => $country['iso2'] ?? null,
        'capital' => '',
        'region' => '',
        'subregion' => '',
        'population' => 0,
        'currency' => $country['currency'] ?? '',
        'currency_symbol' => '',
        'flag' => $country['flag'] ?? '',
        'latitude' => null,
        'longitude' => null,
    ]

);
            $imported++;
        }

        $this->info('=========================================');
        $this->info('Import Countries Berhasil');
        $this->info('Data berhasil diproses : ' . $imported);
        $this->info('Total di Database      : ' . Country::count());
        $this->info('=========================================');

        return Command::SUCCESS;
    }
}
