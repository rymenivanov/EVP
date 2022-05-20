<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
    	'title', 'iso_code', 'continent'
    ];

    public function stations()
    {
    	return $this->hasMany('App\Station');
    }
}
