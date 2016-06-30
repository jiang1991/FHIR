<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
    * 自定义主键
    **/
    protected $primaryKey = 'patientId';
}
