<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function trips()
    {
        return $this->hasMany('App\Trip');
    }

    public function searches()
    {
        return $this->hasMany('App\Search');
    }

    public function plans()
    {
        return $this->hasManyThrough('App\Plan', 'App\Trip');
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
