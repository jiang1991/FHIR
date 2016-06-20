<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;

/**
 * shareTo
 */
class shareToController extends Controller
{

  function shareTo()
  {
    $user Auth::user();
    $userId = $user->id;

    $shareToJson = file_get_contents("php://input");
    $shareToData = json_decode($shareToJson);

    $patientId = $shareToData->PatientId;
    $toEmail = $shareToData->toEmail;

    DB::table('ShareTo')->insert([
      'userId' => "$userId",
      'patientId' => "$patientId",
      'active' => "1",
    ]);

    $response["acitve"] = 1;
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}


 ?>
