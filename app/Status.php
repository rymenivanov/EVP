<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	public $table = 'status_types';

    public function stations()
    {
    	return $this->hasMany('App\Station');
    }
}
