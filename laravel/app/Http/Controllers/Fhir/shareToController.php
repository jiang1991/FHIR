<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;
use App\Share;
use App\Patient;
use App\User;
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

    if ($share_id = User::where('email', $email)->value('id')) {

      Share::withTrashed()->where('user_id', $share_id)
          ->where('patient_id', $shareToData->patientId)
          ->restore();

      $share = Share::firstOrNew([
        'user_id' => $share_id,
        'patient_id' => $shareToData->patientId
      ]);

      $share->save();

      $response["status"] = "ok";
    } else {
      $response["status"] = "error";
      $response["error"] = "Invalid cloud account!";
    }
    return response($response)
      ->header('Content-Type', 'application/json+fhir');


  }

  // 查询分享来的patient
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

  // delete or cancel
  function destroy()
  {
    $user = Auth::user();
    $user_id = $user->id;

    $destoryJson = file_get_contents("php://input");
    $destroyData = json_decode($destoryJson);

    $email = $destroyData->toEmail;

    $share_id = DB::table('users')->where('email', $email)->value('id');

    if ($destroyData->method === 'destroy' ) {
      $shareRecord = Share::where('user_id', $share_id)
                          ->where('patient_id', $destroyData->patientId)
                          ->forceDelete();
    } else {
      $shareRecord = Share::where('user_id', $share_id)
                          ->where('patient_id', $destroyData->patientId)
                          ->delete();
    }

    $shareRecord = Share::where('user_id', $share_id)
                        ->where('patient_id', $destroyData->patientId)
                        ->delete();

    $response["status"] = 'ok';
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }

  // 分享给了那些人，包括软删除
  function query($patient_id)
  {
    $response = collect([ ]);

    $shares = Share::withTrashed()->where('patient_id', $patient_id)->get();

    foreach ($shares as $share) {
      $user = User::find($share->user_id);
      $res["email"] = $user->email;
      if ($share->trashed()) {
        $res["active"] = "0";
      } else {
        $res["active"] = "1";
      }

      $response->push($res);
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}


 ?>
