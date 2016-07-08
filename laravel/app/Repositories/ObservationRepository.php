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
  // $id is Patient ID
  public function observation($id)
  {
    return Patient::find($id)->observations;
  }
}



 ?>
