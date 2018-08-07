<?php

namespace App\Http\Controllers;

use Auth;
use App\Patient;
use App\Observation;
use App\Share;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;

/**
 *
 */
class AdminController extends Controller
{
  protected $patients;

  public function __construct(PatientRepository $patients)
  {
    $this->middleware('auth');
    $this->patients = $patients;
  }

  public function index(Request $request)
  {
    return view('admin',[
      'patients' => $this->patients->forUser($request->user()),
    ]);
  }

  function destroy($patient)
  {
    // Patient::destroy($patient);
    Share::where('patient_id', $patient)->delete();
    Observation::where('patient_id', $patient)->delete();
    Patient::find($patient)->delete();

    return redirect("/viatomadmin");
  }
}
