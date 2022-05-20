<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    public $fillable = [
    	'data', 'hash'
    ];

    protected $casts = [
        'data' => 'object'
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
