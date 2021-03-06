<?php
namespace App\Http\Controllers;

use App\Observation;
use Illuminate\Routing\Controller;
use Auth;
use App\Repositories\PatientRepository;

/**
 * a patient
 */
class MyController extends Controller
{
  protected $patient;

  public function __construct(PatientRepository $patient)
  {
    $this->middleware('auth');
    $this->patient = $patient;
  }

  function MyPatient($patient_id)
  {
    $observations = Observation::where('patient_id', $patient_id)->get();

    // return json_encode($observations);

    return view('patient',[
      'patient' => $this->patient->patient($patient_id),
      'observations' => $observations,
    ]);
  }
}
