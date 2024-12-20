<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportedCountry extends Model
{
    protected $table = 'supported_countries';
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class, 'currency_id');
    }
}
