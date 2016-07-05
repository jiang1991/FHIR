<?php

namespace App\Repositories;

use App\User;
use App\Patient;

class PatientRepository{
  /**
  * Get all Patietns for a given user.
  * @param User $user
  * @return Collection
  */

  public function forUser(User $user)
  {
    return Patient::where('user_id', $user->id)->get();
  }
}

 ?>
