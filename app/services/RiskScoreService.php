<?php

namespace App\Services;

use App\Models\Country;
use App\Models\RiskScore;

class RiskScoreService
{

    public function generate()
    {

        $countries = Country::with([
            'weatherLog',
            'economicData',
            'news'
        ])->get();


        foreach($countries as $country)
        {

            /*
            ==========================
            WEATHER SCORE
            ==========================
            */

            $weatherScore = 0;


            if($country->weatherLog)
            {

                $weather = $country->weatherLog;


                if($weather->storm_risk == 3)
                {
                    $weatherScore = 40;
                }
                elseif($weather->storm_risk == 2)
                {
                    $weatherScore = 25;
                }
                elseif($weather->storm_risk == 1)
                {
                    $weatherScore = 10;
                }


                if($weather->wind_speed > 50)
                {
                    $weatherScore += 10;
                }


                if($weather->rainfall > 100)
                {
                    $weatherScore += 10;
                }

            }



            /*
            ==========================
            ECONOMY SCORE
            ==========================
            */


            $economyScore = 0;


            $economy = $country->economicData
                        ->sortByDesc('year')
                        ->first();


            if($economy)
            {


                if($economy->inflation > 10)
                {
                    $economyScore += 30;
                }
                elseif($economy->inflation > 5)
                {
                    $economyScore += 15;
                }



                if($economy->gdp < 10000)
                {
                    $economyScore += 20;
                }


            }




            /*
            ==========================
            NEWS SCORE
            ==========================
            */


            $newsScore = 0;


            $newsCount = $country->news->count();


            if($newsCount > 20)
            {
                $newsScore = 30;
            }
            elseif($newsCount > 10)
            {
                $newsScore = 20;
            }
            elseif($newsCount > 0)
            {
                $newsScore = 10;
            }



            /*
            ==========================
            TOTAL
            ==========================
            */


            $total =
                $weatherScore +
                $economyScore +
                $newsScore;



            /*
            ==========================
            LEVEL
            ==========================
            */


            if($total >= 70)
            {
                $level = "High";
            }
            elseif($total >= 40)
            {
                $level = "Medium";
            }
            else
            {
                $level = "Low";
            }



            RiskScore::updateOrCreate(

                [
                    'country_id'=>$country->id
                ],


                [

                    'weather_score'=>$weatherScore,

                    'economy_score'=>$economyScore,

                    'news_score'=>$newsScore,

                    'total_score'=>$total,

                    'risk_level'=>$level

                ]

            );


        }


    }


}
