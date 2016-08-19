<?php
namespace App\Http\Controllers\Fhir;

use App\Patient;
use Illuminate\Routing\Controller;
use Auth;


/**
 * Patient
 */
class PatientController extends Controller
{

  function PatientCreate()
  {
    $user = Auth::user();
    $user_id = $user->id;

    $patientJson = file_get_contents("php://input");
    $patientData = json_decode($patientJson);

    $medicalId = $patientData->identifier->medicalId;

    /**
     * 判断是否上传过 上传过则更改 user_id 为当前 用户
     */
    if ($patient = Patient::where('medicalId', $medicalId)->first()) {
      $patient->user_id = $user_id;
      $patient->save();

      $patient_id = $patient->id;
    } else {
      $npatient = new Patient;
      $npatient->resourceType = $patientData->resourceType;
      $npatient->user_id = $user_id;
      $npatient->identifier_system = $patientData->identifier->system;
      $npatient->identifier_value = $patientData->identifier->value;
      $npatient->medicalId = $patientData->identifier->medicalId;
      $npatient->active = $patientData->active;
      $npatient->name = $patientData->name;
      $npatient->gender = $patientData->gender;
      $npatient->birthDate = $patientData->birthDate;
      $npatient->height = $patientData->height;
      $npatient->weight = $patientData->weight;
      $npatient->stepSize = $patientData->stepSize;

      $npatient->save();

      $patient_id = Patient::where('medicalId', "$medicalId")->first()->id;
    }

    $response["patient_id"] = "$patient_id";
    $response["user_id"] = "$user_id";
    $response["medical_id"] = "$medicalId";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'http://api.viatomtech.com.cn/patient/' . $patient_id);
  }

  function PatientRead($patient_id)
  {
    // TODO: 判断该 user 是否有权限获取该 patient 信息

    /** Eloquent Model 查询不到则404 **/
    $sql = Patient::findOrFail($patient_id);

    $response["resourceType"] = $sql->resourceType;
    $response["user_id"] = $sql->user_id;
    $response["identifier"]["system"] = $sql->identifier_system;
    $response["identifier"]["value"] = $sql->identifier_value;
    $response["identifier"]["medicalId"] = $sql->medicalId;
    $response["active"] = $sql->active;
    $response["name"] = $sql->name;
    $response["gender"] = $sql->gender;
    $response["birthDate"] = $sql->birthDate;
    $response["height"] = $sql->height;
    $response["weight"] = $sql->weight;
    $response["stepSize"] = $sql->stepSize;


    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }

}
