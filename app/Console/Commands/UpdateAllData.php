<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAllData extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'update:all';

    /**
     * Deskripsi command
     */
    protected $description = 'Update seluruh data Supply Chain Risk Intelligence';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('==========================================');
        $this->info('GLOBAL SUPPLY CHAIN RISK INTELLIGENCE');
        $this->info('Updating All Data...');
        $this->info('==========================================');

        // Import Countries
        $this->call('countries:import');

        // Import Weather
        $this->call('weather:import');

        // Import Economy
        $this->call('economy:import');

        // Import News
        $this->call('news:import');

        // Generate Risk Score
        $this->call('risk:generate');

        $this->info('');
        $this->info('==========================================');
        $this->info('Semua data berhasil diperbarui.');
        $this->info('==========================================');

        return Command::SUCCESS;
    }
}
