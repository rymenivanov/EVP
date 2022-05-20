<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public $fillable = [
    	'title', 'description', 'hash'
    ];

    public $timestamps = false;

    public function vehicles()
    {
    	return $this->hasMany('App\Vehicle');
    }

    public function makes()
    {
    	return $this->hasMany('App\Make');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
