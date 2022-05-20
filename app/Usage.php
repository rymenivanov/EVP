<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
	public $table = 'usage_types';

    public function stations()
    {
    	return $this->hasMany('App\Station');
    }
}
