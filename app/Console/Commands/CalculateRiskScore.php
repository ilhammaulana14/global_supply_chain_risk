<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\RiskScore;

class CalculateRiskScore extends Command
{
    protected $signature = 'risk:calculate';

    protected $description = 'Calculate Supply Chain Risk Score';

    public function handle()
    {
        $this->info('Menghitung Risk Score...');

        foreach (Country::with([
            'weatherLog',
            'economicData',
            'news'
        ])->get() as $country) {

            /*
            |--------------------------------------------------------------------------
            | WEATHER SCORE
            |--------------------------------------------------------------------------
            */

            $weather = $country->weatherLog;

            $weatherScore = 0;

            if ($weather) {

                if ($weather->storm_risk == 3) {
                    $weatherScore = 100;
                } elseif ($weather->storm_risk == 2) {
                    $weatherScore = 70;
                } elseif ($weather->storm_risk == 1) {
                    $weatherScore = 40;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | ECONOMY SCORE
            |--------------------------------------------------------------------------
            */

            $economy = $country->economicData()->latest()->first();

            $economyScore = 0;

            if ($economy) {

                if ($economy->inflation > 8) {
                    $economyScore += 50;
                } elseif ($economy->inflation > 5) {
                    $economyScore += 30;
                }

                if ($economy->gdp < 100000000000) {
                    $economyScore += 50;
                } elseif ($economy->gdp < 500000000000) {
                    $economyScore += 20;
                }

                if ($economyScore > 100) {
                    $economyScore = 100;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | NEWS SCORE
            |--------------------------------------------------------------------------
            */

            $newsCount = $country->news()->count();

            if ($newsCount >= 15) {
                $newsScore = 100;
            } elseif ($newsCount >= 10) {
                $newsScore = 70;
            } elseif ($newsCount >= 5) {
                $newsScore = 40;
            } else {
                $newsScore = 20;
            }

            /*
            |--------------------------------------------------------------------------
            | TOTAL
            |--------------------------------------------------------------------------
            */

            $total = round(

                ($weatherScore * 0.4) +
                ($economyScore * 0.35) +
                ($newsScore * 0.25)

            );

            /*
            |--------------------------------------------------------------------------
            | LEVEL
            |--------------------------------------------------------------------------
            */

            if ($total >= 70) {
                $level = 'High';
            } elseif ($total >= 40) {
                $level = 'Medium';
            } else {
                $level = 'Low';
            }

            /*
            |--------------------------------------------------------------------------
            | SAVE
            |--------------------------------------------------------------------------
            */

            RiskScore::updateOrCreate(

                [
                    'country_id' => $country->id
                ],

                [
                    'weather_score' => $weatherScore,
                    'economy_score' => $economyScore,
                    'news_score' => $newsScore,
                    'total_score' => $total,
                    'risk_level' => $level
                ]

            );

            $this->info(
                "✔ {$country->name} ({$total}) {$level}"
            );
        }

        $this->newLine();

        $this->info("==============================");
        $this->info("Risk Score selesai dihitung");
        $this->info("==============================");

        return Command::SUCCESS;
    }
}
