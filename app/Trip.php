<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $fillable = [
    	'start_point', 'end_point', 'details', 'hash'
    ];

    protected $casts = [
    	'start_point' => 'object',
    	'end_point' => 'object',
    	'details' => 'object',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
