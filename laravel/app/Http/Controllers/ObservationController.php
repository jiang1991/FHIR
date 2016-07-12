<?php
namespace App\Http\Controllers;

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

  public function __construct(ObservationRepository $observation)
  {
    $this->middleware('auth');
    $this->observation = $observation;
  }

  function MyObservation($observation_id)
  {
    $observation_components = Observation_component::where('observation_id', $observation_id)->get();

    return view('observation',[
      'observation' => $this->observation->observation($observation_id),
      'observation_components' => $observation_components,
    ]);
  }
}



 ?>
