<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;
use App\Share;
use App\Patient;
/**
 * shareTo
 */

 // TODO: 被分享的用户不一定要求注册，直接分享 or 发邮件通知
class shareToController extends Controller
{

  function shareTo()
  {
    $user = Auth::user();
    $userId = $user->id;

    $shareToJson = file_get_contents("php://input");
    $shareToData = json_decode($shareToJson);

    $email = $shareToData->toEmail;

    $share_id = DB::table('users')->where('email', $email)->value('id');

    $share = Share::firstOrCreate([
      'user_id' => $share_id,
      'patient_id' => $shareToData->patientId
    ]);
    // $share = new Share;
    // $share->user_id = $share_id;
    // $share->patient_id = $shareToData->patientId;
    //
    // $share->save();

    $response["status"] = "ok";
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }

  function getShare()
  {
    $sharePatients = collect([ ]);
    $user = Auth::user();
    $shares = Share::where('user_id', $user->id)->get();
    foreach ($shares as $share) {
      $sharePatient = Patient::find($share->patient_id);

      $patient["resourceType"] = $sharePatient->resourceType;
      $patient["user_id"] = $sharePatient->user_id;
      $patient["identifier"]["system"] = $sharePatient->identifier_system;
      $patient["identifier"]["value"] = $sharePatient->identifier_value;
      $patient["identifier"]["medicalId"] = $sharePatient->medicalId;
      $patient["active"] = $sharePatient->active;
      $patient["name"] = $sharePatient->name;
      $patient["gender"] = $sharePatient->gender;
      $patient["birthDate"] = $sharePatient->birthDate;
      $patient["height"] = $sharePatient->height;
      $patient["weight"] = $sharePatient->weight;
      $patient["stepSize"] = $sharePatient->stepSize;
      $sharePatients->push($patient);
    }

    return response($sharePatients)
      ->header('Content-Type', 'application/json+fhir');
  }

  function destroy()
  {
    $user = Auth::user();
    $user_id = $user->id;

    $destoryJson = file_get_contents("php://input");
    $destroyData = json_decode($destoryJson);

    $email = $destroyData->toEmail;

    $share_id = DB::table('users')->where('email', $email)->value('id');

    $shareRecord = Share::where('user_id', $share_id)
                        ->where('patient_id', $destroyData->patientId)
                        ->delete();

    $response["status"] = 'ok';
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}


 ?>
