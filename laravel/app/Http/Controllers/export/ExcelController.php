<?php
namespace App\Http\Controllers\export;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Observation;
use App\Observation_component;

use Excel;

class ExcelController extends Controller
{
  public function export(){
    $observations = collect([['id','patient id','patient name','record type', 'identifier value','analysis code', 'analysis statement','record time', 'upload time',]]);
    $components = collect([['id', 'observation id', 'record component', 'type record value', 'value unit', 'record string',]]);

    $q_observations = Observation::where('patient_id', 1)->get();
    foreach ($q_observations as $q_observation) {
      $observations->push([
        $q_observation->id,
        $q_observation->patient_id,
        $q_observation->subject_display,
        $q_observation->resourceId,
        $q_observation->identifier_value,
        $q_observation->interpretation_display,
        $q_observation->interpretation_text,
        $q_observation->effectiveDateTime,
        $q_observation->created_at,
      ]);
      $q_components = Observation_component::where('observation_id', "$q_observation->id")->get();
      foreach($q_components as $q_component) {
        $components->push([
          $q_component->id,
          $q_component->observation_id,
          $q_component->code_display,
          $q_component->valueQuantity_value,
          $q_component->valueQuantity_code,
          $q_component->valueString,
        ]);
      }
    }


    Excel::create('observation',function($excel) use ($observations){
      $excel->sheet('observation', function($sheet) use ($observations){
        $sheet->rows($observations);
      });
    })->store('xlsx');
    Excel::create('component',function($excel) use ($components){
      $excel->sheet('component', function($sheet) use ($components){
        $sheet->rows($components);
      });
    })->store('xlsx');
  }
}


 ?>
