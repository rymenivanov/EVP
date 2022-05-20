<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $fillable = [
        'id_number', 'hash'
    ];

    public function manufacturer()
    {
    	return $this->belongsTo('App\Manufacturer');
    }

    public function make()
    {
    	return $this->belongsTo('App\Make');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function setHashAttribute($value)
    {
        $this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
