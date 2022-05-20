<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
    	'title', 'address', 'town', 'state', 'postcode', 'lat', 'lng', 'hash'
    ];

    public function country()
    {
    	return $this->belongsTo('App\Country');
    }

    public function stations()
    {
    	return $this->hasMany('App\Station');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
