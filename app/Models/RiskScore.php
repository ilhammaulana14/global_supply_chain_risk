<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $fillable = [

    'country_id',

    'weather_score',

    'port_score',

    'economy_score',

    'news_score',

    'total_score',

    'risk_level',

];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
