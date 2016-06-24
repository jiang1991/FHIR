<?php
namespace App\Http\Controllers\Fhir;

use DB;
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
    $userId = $user->id;

    $patientJson = file_get_contents("php://input");
    $patientData = json_decode($patientJson);

    $resourceType = $patientData->resourceType;
    $identifier_system = $patientData->identifier->system;
    $identifier_value = $patientData->identifier->value;
    $medicalId = $patientData->identifier->medicalId;
    $active = $patientData->active;
    $name = $patientData->name;
    $gender = $patientData->gender;
    $birthDate = $patientData->birthDate;
    $height = $patientData->height;
    $weight = $patientData->weight;
    $stepSize = $patientData->stepSize;

    $result1 = DB::table('Patient')->insert([
      'resourceType' => "$resourceType",
      'userId' => "$userId",
      'identifier_system' => "$identifier_system",
      'identifier_value' => "$identifier_value",
      'medicalId' => "$medicalId",
      'active' => "$active",
      'name' => "$name",
      'gender' => "$gender",
      'birthDate' => "$birthDate",
      'height' => "$height",
      'weight' => "$weight",
      'stepSize' => "$stepSize"
    ]);

    $patientId = DB::table('Patient')->WHERE('medicalId', "$medicalId")
                ->first()->patientId;
    $response["patientId"] = "$patientId";
    $response["userId"] = "$userId";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'http://api.viatomtech.com.cn/patient/' . $patientId);
  }

  function PatientRead($patientId)
  {
    // TODO: 这里先判断该 patient 是否存在
    // TODO: 判断该 user 是否有权限获取该 patient 信息

    $query = DB::table('Patient')->WHERE('patientId', "$patientId")->first();

    $response["resourceType"] = $query->resourceType;
    $response["userId"] = $query->userId;
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
