<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [

    [
        'country'=>'Indonesia',
        'name'=>'Port of Tanjung Priok',
        'code'=>'IDTP',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Indonesia',
        'name'=>'Port of Tanjung Perak',
        'code'=>'IDTR',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Singapore',
        'name'=>'Port of Singapore',
        'code'=>'SGPS',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Malaysia',
        'name'=>'Port Klang',
        'code'=>'MYPK',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Malaysia',
        'name'=>'Port of Penang',
        'code'=>'MYPN',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Thailand',
        'name'=>'Laem Chabang Port',
        'code'=>'THLC',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Vietnam',
        'name'=>'Hai Phong Port',
        'code'=>'VNHP',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Philippines',
        'name'=>'Port of Manila',
        'code'=>'PHMN',
        'type'=>'Seaport',
    ],

    [
        'country'=>'China',
        'name'=>'Port of Shanghai',
        'code'=>'CNSH',
        'type'=>'Seaport',
    ],

    [
        'country'=>'China',
        'name'=>'Port of Shenzhen',
        'code'=>'CNSZ',
        'type'=>'Seaport',
    ],

        [
        'country'=>'China',
        'name'=>'Port of Ningbo',
        'code'=>'CNNB',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Japan',
        'name'=>'Port of Yokohama',
        'code'=>'JPYK',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Japan',
        'name'=>'Port of Kobe',
        'code'=>'JPKB',
        'type'=>'Seaport',
    ],

    [
        'country'=>'South Korea',
        'name'=>'Port of Busan',
        'code'=>'KRBS',
        'type'=>'Seaport',
    ],

    [
        'country'=>'India',
        'name'=>'Jawaharlal Nehru Port',
        'code'=>'INJN',
        'type'=>'Seaport',
    ],

    [
        'country'=>'India',
        'name'=>'Chennai Port',
        'code'=>'INCH',
        'type'=>'Seaport',
    ],

    [
        'country'=>'United Arab Emirates',
        'name'=>'Jebel Ali Port',
        'code'=>'AEJA',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Saudi Arabia',
        'name'=>'Jeddah Islamic Port',
        'code'=>'SAJD',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Netherlands',
        'name'=>'Port of Rotterdam',
        'code'=>'NLRT',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Belgium',
        'name'=>'Port of Antwerp',
        'code'=>'BEAN',
        'type'=>'Seaport',
    ],

        [
        'country'=>'Germany',
        'name'=>'Port of Hamburg',
        'code'=>'DEHM',
        'type'=>'Seaport',
    ],

    [
        'country'=>'France',
        'name'=>'Port of Marseille',
        'code'=>'FRMS',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Italy',
        'name'=>'Port of Genoa',
        'code'=>'ITGN',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Spain',
        'name'=>'Port of Valencia',
        'code'=>'ESVL',
        'type'=>'Seaport',
    ],

    [
        'country'=>'United Kingdom',
        'name'=>'Port of Felixstowe',
        'code'=>'GBFX',
        'type'=>'Seaport',
    ],

    [
        'country'=>'United States',
        'name'=>'Port of Los Angeles',
        'code'=>'USLA',
        'type'=>'Seaport',
    ],

    [
        'country'=>'United States',
        'name'=>'Port of Long Beach',
        'code'=>'USLB',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Canada',
        'name'=>'Port of Vancouver',
        'code'=>'CAVN',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Brazil',
        'name'=>'Port of Santos',
        'code'=>'BRST',
        'type'=>'Seaport',
    ],

    [
        'country'=>'Australia',
        'name'=>'Port of Melbourne',
        'code'=>'AUMB',
        'type'=>'Seaport',
    ],

];


       foreach ($ports as $item) {

    $country = Country::where('name', $item['country'])->first();

    if (!$country) {
        continue;
    }

    Port::updateOrCreate(

        [
            'country_id' => $country->id,
            'name'       => $item['name'],
        ],

        [
            'code'              => $item['code'],
            'type'              => $item['type'],
            'status'            => rand(1, 3),
            'latitude'          => $country->latitude,
            'longitude'         => $country->longitude,
            'congestion_level'  => rand(10, 95),
        ]

    );

} // <-- tutup foreach

} // <-- tutup function run()

} // <-- tutup class PortSeeder
