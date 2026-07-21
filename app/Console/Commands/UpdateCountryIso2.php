<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateCountryIso2 extends Command
{
    protected $signature = 'country:update-iso2';

    protected $description = 'Update ISO2 country codes';

    public function handle()
    {
        $this->info('Mengambil data ISO2 dari API...');

        $response = Http::get(
            'https://countriesnow.space/api/v0.1/countries/info?returns=iso2,iso3'
        );

        if (!$response->successful()) {
            $this->error('Gagal mengambil data.');
            return Command::FAILURE;
        }

        $countries = $response->json()['data'];

        $updated = 0;

        foreach ($countries as $item) {

            Country::where('code', $item['iso3'])
                ->update([
                    'iso2' => $item['iso2']
                ]);

            $updated++;
        }

        $this->info("==================================");
        $this->info("ISO2 berhasil diupdate");
        $this->info("Total : {$updated}");
        $this->info("==================================");

        return Command::SUCCESS;
    }
}
