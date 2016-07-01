<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
    public function observation_components()
    {
      return $this->hasMany('App\Observation_component');
    }
}
