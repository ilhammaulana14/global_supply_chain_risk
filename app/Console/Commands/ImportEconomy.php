<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\EconomicData;
use Illuminate\Console\Command;

class ImportEconomy extends Command
{
    protected $signature = 'economy:import';

    protected $description = 'Generate realistic economy data';

    public function handle()
    {
        $this->info('Generating economy data...');

        $countries = Country::all();

        $success = 0;

        foreach ($countries as $country) {

            EconomicData::updateOrCreate(

                [
                    'country_id' => $country->id,
                    'year' => now()->year,
                ],

                [

                    // GDP (USD)
                    'gdp' => rand(50, 20000) * 1000000000,

                    // Inflasi (%)
                    'inflation' => rand(10, 120) / 10,

                    // Export (USD)
                    'exports' => rand(5, 5000) * 100000000,

                    // Import (USD)
                    'imports' => rand(5, 5000) * 100000000,

                ]

            );

            $success++;

            $this->info("✔ {$country->name}");
        }

        $this->newLine();

        $this->info("==============================");
        $this->info("Economy Data Generated");
        $this->info("Total : {$success}");
        $this->info("==============================");

        return Command::SUCCESS;
    }
}
