<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;
use App\Patient;

class searchController extends Controller
{
  function search($param)
  {
    /*查询 user id*/
    $user = Auth::user();
    $user_id = $user->id;

    if ($param == 'patient') {
      $patients = Patient::where('user_id', "$user_id")->get();

      foreach ($patients as $patient) {
        $result["patient_id"] = $patient->id;
        $result["medical_id"] = $patient->medicalId;
        $result["name"] = $patient->name;
        $response[] = $result;
      }

    } else {
      # code...
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}
