<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDF;

use App\Patient;
use App\Observation;
use App\Observation_component;

use App\Repositories\ObservationRepository;

/**
 * export observation pdf
 */
class PdfController extends Controller
{
  protected $observation;
  protected $patient;

  function __construct(ObservationRepository $observation)
  {
    $this->observation = $observation;
  }

  function export($observation_id)
  {
    /*$patient = $this->observation->observation($observation_id)->patient;
    $observation = $this->observation->observation($observation_id);
    $observation_components = Observation_component::where('observation_id', $observation_id)->get();*/

    /*$pdf = PDF::loadView('export.pdf', [
      'patient' => $patient,
      'observation' => $observation,
      'observation_components' => $observation_components,
      ]);

    return $pdf->download('sleep_report_' . $observation_id . '.pdf');*/

    /*return view('export.pdf', [
      'patient' => $patient,
      'observation' => $observation,
      'observation_components' => $observation_components,
      ]);*/


    /*$pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();*/
    return PDF::loadHTML('<h1>Test</h1>')->stream();
  }
}
