<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;
use App\Patient;
use App\Observation;

class searchController extends Controller
{
  function patientSearch()
  {
    /*查询 user id*/
    $user = Auth::user();
    $user_id = $user->id;

    $patients = Patient::where('user_id', "$user_id")->get();

    foreach ($patients as $patient) {
      $result["patient_id"] = $patient->id;
      $result["medical_id"] = $patient->medicalId;
      $result["name"] = $patient->name;
      $response[] = $result;
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }

  function ObservationSearch($patient_id) {
    $user = Auth::user();
    $user_id = $user->id;

    $patient = Patient::find($patient_id);

    if ($patient->user_id != $user_id) {
      $error["status"] = "error";
      $error["error"] = "unauthorized";

      return response($error, '401')
        ->header('Content-Type', 'application/json+fhir');
    }

    $observations = Observation::where('patient_id', $patient_id)->get();

    foreach ($observations as $observation) {
      $result["patient_id"] = $patient_id;
      $result["observation_id"] = $observation->id;
      $result["resorce_id"] = $observation->resourceId;
      $result["device_sn"] = $observation->device_sn;

      $response[] = $result;
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}
