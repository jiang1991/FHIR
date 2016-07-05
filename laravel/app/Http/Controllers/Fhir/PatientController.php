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

    $patient = new Patient;
    $patient->resourceType = $patientData->resourceType;
    $patient->user_id = $user_id;
    $patient->identifier_system = $patientData->identifier->system;
    $patient->identifier_value = $patientData->identifier->value;
    $patient->medicalId = $patientData->identifier->medicalId;
    $patient->active = $patientData->active;
    $patient->name = $patientData->name;
    $patient->gender = $patientData->gender;
    $patient->birthDate = $patientData->birthDate;
    $patient->height = $patientData->height;
    $patient->weight = $patientData->weight;
    $patient->stepSize = $patientData->stepSize;

    $patient->save();

    $patient_id = Patient::where('medicalId', "$medicalId")->first()->id;
    $response["patient_id"] = "$patient_id";
    $response["user_id"] = "$user_id";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'http://api.viatomtech.com.cn/patient/' . $patient_id);
  }

  function PatientRead($patient_id)
  {
    // TODO: 判断该 user 是否有权限获取该 patient 信息

    /** Eloquent Model 查询不到则404 **/
    $query = Patient::firstOrFail($patient_id);

    $response["resourceType"] = $query->resourceType;
    $response["user_id"] = $query->user_id;
    $response["identifier"]["system"] = $query->identifier_system;
    $response["identifier"]["value"] = $query->identifier_value;
    $response["identifier"]["medicalId"] = $query->medicalId;
    $response["active"] = $query->active;
    $response["name"] = $query->name;
    $response["gender"] = $query->gender;
    $response["birthDate"] = $query->birthDate;
    $response["height"] = $query->height;
    $response["weight"] = $query->weight;
    $response["stepSize"] = $query->stepSize;

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }

}