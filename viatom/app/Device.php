<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{

	use SoftDeletes;
	protected $fillable = [
		'user_id',
		'device_name',
		'device_sn'
	];
	
    public function oxiupload()
    {
    	return $this->hasMany('App\Oxiupload');
    }
}
