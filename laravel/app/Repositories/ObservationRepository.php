<?php

namespace App\Repositories;

use App\User;
use App\Observation;
use App\Observation_component;

/**
 * @param Patient $patient
 * @return Observation Collection
 */
class ObservationRepository
{
  // $observation_id
  public function observation($observation_id)
  {
    return Observation::find($observation_id);
  }
}



 ?>
