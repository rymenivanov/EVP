<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $fillable = [
    	'title', 'on', 'hash'
    ];

    protected $casts = [
    	'data' => 'object'
    ];

    protected $dates = [
        'on', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function trip()
    {
        return $this->belongsTo('App\Trip');
    }

    public function setHashAttribute($value)
    {
    	$this->attributes['hash'] = Uuid::uuid1()->toString();
    }
}
