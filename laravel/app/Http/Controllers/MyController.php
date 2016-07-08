<?php
namespace App\Http\Controllers;

use App\Patient;
// use App\Http\Requests;
use Illuminate\Routing\Controller;
// use Illuminate\Http\Request;
use Auth;
// use App\Http\Controllers\Controller;
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

  function MyPatient($id)
  {
    return view('patient',[
      'patient' => $this->patient->patient($id),
    ]);
  }
}
