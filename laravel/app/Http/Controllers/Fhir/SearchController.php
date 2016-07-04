<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;

class searchController extends Controller
{
  function search()
  {
    /*查询 user id*/
    $user = Auth::user();
    $user_id = $user->id;

    /**
    * Response 分为 user 自身上传的和 分享给他的
    * $response->self   $response->share
    **/

    $userResults = DB::table('records')->WHERE('user_id', "$user_id")->get();
    // $userResults->isEmpty()
    if (!empty($userResults)) {
      $i = 0;
      foreach ($userResults as $userResult) {
        $response["user"][$i] = $userResult;
        $i++;
      }
    }

    /*查询分享给这个 user 的 patient Id */
    $patient_ids = DB::table('shares')->WHERE('user_id', "$user_id")->value('patient_id');

    // !$patient_ids->isEmpty()
    if (!empty($patient_ids)) {
      $i = 0;
      foreach ($patient_ids as $patient_id) {
        $patientResults = DB::table('records')->WHERE('patient_id', "$patient_id")->get();
        foreach ($patientResults as $patientResult) {
          $Response["share"][$i] = $patientResult;
          $i++;
        }
      }
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}
