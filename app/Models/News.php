<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [

    'country_id',
    'title',
    'description',
    'source',
    'author',
    'url',
    'image',
    'published_at',

];
    protected $casts = [

        'published_at' => 'date',

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
