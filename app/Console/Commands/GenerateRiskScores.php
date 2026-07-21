<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\RiskScore;

class GenerateRiskScores extends Command
{
    protected $signature = 'risk:generate';

    protected $description = 'Generate Supply Chain Risk Score';

    public function handle()
    {
        $this->info('Generating Risk Scores...');

        $countries = Country::with([
            'weatherLog',
            'economicData',
            'news'
        ])->get();

        foreach ($countries as $country) {

            /*
            |--------------------------------------------------------------------------
            | WEATHER SCORE
            |--------------------------------------------------------------------------
            */

            $weatherScore = 0;

            if ($country->weatherLog) {

                $weather = $country->weatherLog;

                $weatherScore =
                    ($weather->storm_risk ?? 0) * 0.5 +
                    ($weather->wind_speed ?? 0) * 0.3 +
                    ($weather->rainfall ?? 0) * 0.2;
            }

            /*
            |--------------------------------------------------------------------------
            | ECONOMY SCORE
            |--------------------------------------------------------------------------
            */

            $economyScore = 50;

            if ($country->economicData->count()) {

                $eco = $country->economicData->last();

                $economyScore =
                    ($eco->inflation * 4);

                $economyScore = min($economyScore,100);
            }

            /*
            |--------------------------------------------------------------------------
            | NEWS SCORE
            |--------------------------------------------------------------------------
            */

            $newsScore = min(
                $country->news()->count() * 5,
                100
            );

            /*
            |--------------------------------------------------------------------------
            | TOTAL
            |--------------------------------------------------------------------------
            */

            $total = round(

                ($weatherScore * 0.4) +
                ($economyScore * 0.3) +
                ($newsScore * 0.3),

                1

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

            RiskScore::updateOrCreate(

                [

                    'country_id'=>$country->id

                ],

                [

                    'weather_score'=>round($weatherScore,1),

                    'economy_score'=>round($economyScore,1),

                    'news_score'=>round($newsScore,1),

                    'total_score'=>$total,

                    'risk_level'=>$level

                ]

            );

        }

        $this->info('==========================');
        $this->info('Risk Score Generated');
        $this->info('Total Country : '.$countries->count());
        $this->info('==========================');

        return Command::SUCCESS;
    }
}
