<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    public $fillable = [
    	'title', 'speed', 'acceleration', 'capacity', 'charging_time', 'range', 'hash'
    ];

    protected $casts = [
        'specification' => 'object'
    ];

    public function manufacturer()
    {
    	return $this->belongsTo('App\Manufacturer');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
