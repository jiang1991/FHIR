<?php

namespace App\Policies;

use App\Patient;
Use App\Observation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class ObservationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function destroy(User $user, Observation $observation)
    {
      $patient = Observation::find($observation)->patient->user_id;
      return $user->id === $patient;
    }
}
