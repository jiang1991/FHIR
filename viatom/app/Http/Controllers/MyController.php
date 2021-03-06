<?php
namespace App\Http\Controllers;

use App\User;
use App\Observation;
use App\Patient;
use App\Share;
Use App\Observation_component;

use Illuminate\Routing\Controller;
use Auth;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

/**
 * a patient
 */
class MyController extends Controller
{
  protected $patient;

  public function __construct(PatientRepository $patient)
  {
    if (request()->cookie('locale') == 'zh') {
            App::setLocale('zh');
        }
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

    /* delete account */
    function destroy() {
        $user = Auth::user();
        User::destroy($user->id);

        return redirect("/login");
    }
}
