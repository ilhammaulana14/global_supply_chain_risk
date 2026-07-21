<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WeatherLog;
use App\Models\EconomicData;
use App\Models\RiskScore;

class Country extends Model
{
    protected $fillable = [

    'name',
    'code',
    'iso2',
    'capital',
    'region',
    'subregion',
    'population',
    'currency',
    'currency_symbol',
    'flag',
    'latitude',
    'longitude',

];

    public function weatherLog()
    {
        return $this->hasOne(WeatherLog::class);
    }

    public function economicData()
    {
        return $this->hasOne(EconomicData::class);
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }


}
