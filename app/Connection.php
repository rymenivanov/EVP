<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    public function stations()
    {
    	return $this->hasMany('App\Station');
    }
}
