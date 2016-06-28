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
    $userId = $user->id;

    /**
    * Response 分为 user 自身上传的和 分享给他的
    * $response->self   $response->share
    **/

    $userResults = DB::table('record')->WHERE('userId', "$userId")->get();
    // $userResults->isEmpty()
    if (!empty($userResults)) {
      $i = 0;
      foreach ($userResults as $userResult) {
        $response["user"][$i] = $userResult;
        $i++;
      }
    }

    /*查询分享给这个 user 的 patient Id */
    $patientIds = DB::table('ShareTo')->WHERE('userId', "$userId")->value('patientId');

    // !$patientIds->isEmpty()
    if (!empty($patientIds)) {
      $i = 0;
      foreach ($patientIds as $patientId) {
        $patientResults = DB::table('record')->WHERE('patientId', "$patientId")->get();
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
