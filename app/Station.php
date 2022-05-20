<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
	use SoftDeletes;

    protected $fillable = [
    	'cost', 'points', 'is_verified', 'remote_id', 'remote_uuid', 'hash'
    ];

    public function address()
    {
    	return $this->belongsTo('App\Address');
    }

    public function status()
    {
    	return $this->belongsTo('App\Status');
    }

    public function usage()
    {
    	return $this->belongsTo('App\Usage');
    }

    public function connection()
    {
    	return $this->hasMany('App\Connection');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
