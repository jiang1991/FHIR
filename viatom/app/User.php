<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'company',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function oxiupload()
    {
        return $this->hasMany('App\Oxiupload');
    }

    public function device()
    {
        return $this->hasMany('App\Device');
    }

    public function link() {
        return $this->hasMany('App\Link');
    }

    public function sharecode() {
        return $this->hasMany('App\Sharecode');
    }

    public function linkshare() {
        return $this->hasMany('App\Linkshare');
    }
}
