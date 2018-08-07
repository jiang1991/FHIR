<?php
namespace App\Http\Controllers;

use App\Observation;
use App\Observation_component;
use Illuminate\Routing\Controller;
use Auth;
use App\Repositories\ObservationRepository;

/**
 * an observation
 */
class ObservationController extends Controller
{
  protected $observation;
  protected $patient;

  public function __construct(ObservationRepository $observation)
  {
    $this->middleware('auth');
    $this->observation = $observation;
  }

  function MyObservation($observation_id)
  {
    $observation_components = Observation_component::where('observation_id', $observation_id)->get();

    return view('observation',[
      'patient' => $this->observation->observation($observation_id)->patient,
      'observation' => $this->observation->observation($observation_id),
      'observation_components' => $observation_components,
    ]);
  }

  function destroy($observation)
  {
    // $this->authorize('destroy', $observation);
    Observation::destroy($observation);
    Observation_component::where('observation_id', $observation)->delete();
    return redirect("/mypatient/" . $_POST["patient_id"]);
  }
}



 ?>
