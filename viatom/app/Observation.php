<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observation extends Model
{
  /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
  public function observation_components()
  {
    return $this->hasMany('App\Observation_component');
  }

  public function patient()
  {
    return $this->belongsTo('App\Patient');
  }
}
