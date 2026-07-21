<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountryCoordinateSeeder extends Seeder
{
    public function run(): void
    {
        $coordinates = [

    // Asia
    'Afghanistan' => [33.9391, 67.7100],
    'Armenia' => [40.0691, 45.0382],
    'Azerbaijan' => [40.1431, 47.5769],
    'Bahrain' => [26.0667, 50.5577],
    'Bangladesh' => [23.6850, 90.3563],
    'Bhutan' => [27.5142, 90.4336],
    'Brunei' => [4.5353, 114.7277],
    'Cambodia' => [12.5657, 104.9910],
    'China' => [35.8617, 104.1954],
    'Cyprus' => [35.1264, 33.4299],
    'Georgia' => [42.3154, 43.3569],
    'India' => [20.5937, 78.9629],
    'Indonesia' => [-2.5489, 118.0149],
    'Iran' => [32.4279, 53.6880],
    'Iraq' => [33.2232, 43.6793],
    'Israel' => [31.0461, 34.8516],
    'Japan' => [36.2048, 138.2529],
    'Jordan' => [30.5852, 36.2384],
    'Kazakhstan' => [48.0196, 66.9237],
    'Kuwait' => [29.3117, 47.4818],
    'Kyrgyzstan' => [41.2044, 74.7661],
    'Laos' => [19.8563, 102.4955],
    'Lebanon' => [33.8547, 35.8623],
    'Malaysia' => [4.2105, 101.9758],
    'Maldives' => [3.2028, 73.2207],
    'Mongolia' => [46.8625, 103.8467],
    'Myanmar' => [21.9162, 95.9560],
    'Nepal' => [28.3949, 84.1240],
    'North Korea' => [40.3399, 127.5101],
    'Oman' => [21.4735, 55.9754],
    'Pakistan' => [30.3753, 69.3451],
    'Palestine' => [31.9522, 35.2332],
    'Philippines' => [12.8797, 121.7740],
    'Qatar' => [25.3548, 51.1839],
    'Saudi Arabia' => [23.8859, 45.0792],
    'Singapore' => [1.3521, 103.8198],
    'South Korea' => [35.9078, 127.7669],
    'Sri Lanka' => [7.8731, 80.7718],
    'Syria' => [34.8021, 38.9968],
    'Taiwan' => [23.6978, 120.9605],
    'Tajikistan' => [38.8610, 71.2761],
    'Thailand' => [15.8700, 100.9925],
    'Timor-Leste' => [-8.8742, 125.7275],
    'Turkey' => [38.9637, 35.2433],
    'Turkmenistan' => [38.9697, 59.5563],
    'United Arab Emirates' => [23.4241, 53.8478],
    'Uzbekistan' => [41.3775, 64.5853],
    'Vietnam' => [14.0583, 108.2772],
    'Yemen' => [15.5527, 48.5164],

    // Europe
    'Albania' => [41.1533, 20.1683],
    'Andorra' => [42.5063, 1.5218],
    'Austria' => [47.5162, 14.5501],
    'Belarus' => [53.7098, 27.9534],
    'Belgium' => [50.5039, 4.4699],
    'Bosnia and Herzegovina' => [43.9159, 17.6791],
    'Bulgaria' => [42.7339, 25.4858],
    'Croatia' => [45.1000, 15.2000],
    'Czech Republic' => [49.8175, 15.4730],
    'Denmark' => [56.2639, 9.5018],
    'Estonia' => [58.5953, 25.0136],
    'Finland' => [61.9241, 25.7482],
    'France' => [46.2276, 2.2137],
    'Germany' => [51.1657, 10.4515],
    'Greece' => [39.0742, 21.8243],
    'Hungary' => [47.1625, 19.5033],
    'Iceland' => [64.9631, -19.0208],
    'Ireland' => [53.4129, -8.2439],
    'Italy' => [41.8719, 12.5674],
    'Kosovo' => [42.6026, 20.9030],
    'Latvia' => [56.8796, 24.6032],
    'Lithuania' => [55.1694, 23.8813],
    'Luxembourg' => [49.8153, 6.1296],
    'Malta' => [35.9375, 14.3754],
    'Moldova' => [47.4116, 28.3699],
    'Monaco' => [43.7384, 7.4246],
    'Montenegro' => [42.7087, 19.3744],
    'Netherlands' => [52.1326, 5.2913],
    'North Macedonia' => [41.6086, 21.7453],
    'Norway' => [60.4720, 8.4689],
    'Poland' => [51.9194, 19.1451],
    'Portugal' => [39.3999, -8.2245],
    'Romania' => [45.9432, 24.9668],
    'Russia' => [61.5240, 105.3188],
    'San Marino' => [43.9424, 12.4578],
    'Serbia' => [44.0165, 21.0059],
    'Slovakia' => [48.6690, 19.6990],
    'Slovenia' => [46.1512, 14.9955],
    'Spain' => [40.4637, -3.7492],
    'Sweden' => [60.1282, 18.6435],
    'Switzerland' => [46.8182, 8.2275],
    'Ukraine' => [48.3794, 31.1656],
    'United Kingdom' => [55.3781, -3.4360],
    'Vatican City' => [41.9029, 12.4534],
        ];

        foreach ($coordinates as $country => $coord) {

            DB::table('countries')
                ->where('name', $country)
                ->update([
                    'latitude' => $coord[0],
                    'longitude' => $coord[1],
                ]);
        }
    }
}
