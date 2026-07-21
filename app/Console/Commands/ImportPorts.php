<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\Port;

class ImportPorts extends Command
{
    protected $signature = 'ports:import';

    protected $description = 'Generate dummy ports';

    public function handle()
    {
        $this->info('Generating Ports...');

        Port::truncate();

        $countries = Country::all();

        $names = [

            'International Port',
            'Container Port',
            'Sea Port',
            'Cargo Port',
            'Harbour',
            'Commercial Port'

        ];

        $types = [

            'Commercial',
            'Container',
            'International',
            'Industrial'

        ];

        $total = 0;

        foreach ($countries as $country) {

            $jumlahPort = rand(1,3);

            for ($i = 1; $i <= $jumlahPort; $i++) {

                Port::create([

    'country_id' => $country->id,

    'name' => $country->name.' '.$names[array_rand($names)],

    'code' => strtoupper(substr($country->code ?? 'PRT',0,3)).rand(100,999),

    'latitude' => $country->latitude
        ? $country->latitude + rand(-100,100)/100
        : rand(-90,90),

    'longitude' => $country->longitude
        ? $country->longitude + rand(-100,100)/100
        : rand(-180,180),

    'type' => 'Commercial',

    // 1 = Active, 0 = Inactive
    'status' => rand(0,1),

]);

                $total++;
            }

            $this->info("✔ ".$country->name);
        }

        $this->newLine();

        $this->info("==========================");
        $this->info("Ports Generated");
        $this->info("Total Port : ".$total);
        $this->info("==========================");

        return Command::SUCCESS;
    }
}
