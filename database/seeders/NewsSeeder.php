<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [

            ['Indonesia','Flood Affects Logistics','Heavy rainfall disrupts supply chain operations.','Reuters'],
            ['Singapore','Port Congestion Increases','Container traffic rises significantly.','Bloomberg'],
            ['Malaysia','Port Klang Expansion','New container terminal begins operation.','The Star'],
            ['China','Export Growth Continues','Export activities continue to grow this month.','Reuters'],
            ['Japan','Earthquake Hits Logistics','Several ports temporarily suspended operations.','NHK'],

            ['South Korea','Busan Port Traffic Rises','Busan records higher cargo movement.','Yonhap'],
            ['Thailand','Factory Output Improves','Manufacturing sector shows positive growth.','Bangkok Post'],
            ['Vietnam','Export Orders Increase','Electronics exports continue to rise.','VN Express'],
            ['India','New Trade Agreement Signed','Government signs new international trade deal.','Economic Times'],
            ['United Arab Emirates','Jebel Ali Port Expands','Port capacity increased to meet demand.','Gulf News'],

            ['Saudi Arabia','Oil Export Stable','Oil export remains stable this quarter.','Arab News'],
            ['Netherlands','Rotterdam Handles More Cargo','Port throughput increases significantly.','Reuters'],
            ['Belgium','Antwerp Logistics Improves','Shipping delays continue to decrease.','Bloomberg'],
            ['Germany','Industrial Production Rises','Manufacturing sector rebounds.','DW'],
            ['France','Transport Strike Ends','Supply chain returns to normal.','France24'],

            ['Italy','Port of Genoa Busy','Import volume increases rapidly.','ANSA'],
            ['Spain','Export Performance Improves','Agricultural exports increase.','EFE'],
            ['United Kingdom','Felixstowe Operations Stable','Container movement returns to normal.','BBC'],
            ['United States','Los Angeles Port Busy','Cargo backlog begins to decline.','CNN'],
            ['Canada','Vancouver Port Expands','New shipping terminal opens.','CBC'],

            ['Brazil','Coffee Export Rises','Brazil exports reach new record.','Reuters'],
            ['Australia','Melbourne Port Upgrade','Infrastructure improvement completed.','ABC'],
            ['Philippines','Port Modernization Begins','Government starts modernization project.','Philippine Daily'],
            ['Turkey','Trade Volume Increases','International trade continues to grow.','Daily Sabah'],
            ['Russia','Rail Freight Improves','Freight capacity increases.','TASS'],

            ['Mexico','Manufacturing Export Grows','Automotive exports increase sharply.','Reuters'],
            ['South Africa','Durban Port Recovers','Operations return after disruption.','News24'],
            ['Egypt','Suez Canal Traffic Normal','Maritime traffic returns to normal.','Al Ahram'],
            ['Pakistan','Textile Export Improves','Export demand continues rising.','Dawn'],
            ['Argentina','Agriculture Shipment Increases','Grain exports improve this month.','Reuters'],

        ];

        foreach ($news as $item) {

            $country = Country::where('name', $item[0])->first();

            if (!$country) {
                continue;
            }

            News::updateOrCreate(

                [
                    'country_id' => $country->id,
                    'title'      => $item[1],
                ],

                [
                    'description' => $item[2],
                    'source'      => $item[3],
                    'author'      => 'SCRI System',
                    'url'         => 'https://example.com/news',
                    'image'       => null,
                    'published_at'=> now()->subDays(rand(0,30)),
                ]

            );
        }
    }
}
