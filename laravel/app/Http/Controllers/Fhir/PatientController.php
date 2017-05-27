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

    // write to local file
    // $filename = "/var/www/cloud/public/test.txt";
    // $filetowirte = fopen($filename, "a");
    // fwrite($filetowirte, date("Y-m-d H:m:s", time()));
    // fwrite($filetowirte, "\n");
    // fwrite($filetowirte, $patientJson);
    // fwrite($filetowirte, "\n");
    // fclose($filetowirte);

    $medicalId = $patientData->identifier->medicalId;
    $name = $patientData->name;
    if ($name == '--') {
      $name = $user->name;
    }

    $patient = Patient::firstOrNew([
      'medicalId' => $medicalId,
      'user_id' => $user_id
    ]);

    $patient->resourceType = $patientData->resourceType;
    // $patient->user_id = $user_id;
    $patient->identifier_system = $patientData->identifier->system;
    $patient->identifier_value = $patientData->identifier->value;
    $patient->medicalId = $medicalId;
    $patient->name = $name;
    $patient->gender = $patientData->gender;
    $patient->birthDate = $patientData->birthDate;
    $patient->height = $patientData->height;
    $patient->weight = $patientData->weight;
    $patient->stepSize = $patientData->stepSize;

    $patient->save();

    // $patient_id = Patient::where('medicalId', "$medicalId")->first()->id;

    $response["patient_id"] = $patient->id;
    $response["user_id"] = "$user_id";
    $response["medical_id"] = "$medicalId";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'https://cloud.viatomtech.com/patient/' . $patient->id);
  }

  function PatientRead($patient_id)
  {
    // TODO: 判断该 user 是否有权限获取该 patient 信息
    $user = Auth::user();
    $user_id = $user->id;

    if ($patient = Patient::where('id', $patient_id)
                          ->where('user_id', $user_id)->first()) {
      $response["resourceType"] = $patient->resourceType;
      $response["user_id"] = $patient->user_id;
      $response["identifier"]["system"] = $patient->identifier_system;
      $response["identifier"]["value"] = $patient->identifier_value;
      $response["identifier"]["medicalId"] = $patient->medicalId;
      $response["name"] = $patient->name;
      $response["gender"] = $patient->gender;
      $response["birthDate"] = $patient->birthDate;
      $response["height"] = $patient->height;
      $response["weight"] = $patient->weight;
      $response["stepSize"] = $patient->stepSize;


      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    } else {
      $response["status"] = "error";
      $response["error"] = "unauthorized or not found";

      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    }
  }

  function Search($medical_id)
  {
    $user = Auth::user();
    $user_id = $user->id;

    // 查询该user下是否有次medical_id
    if ($patient = Patient::where('user_id', $user_id)
                          ->where('medicalId', $medical_id)->first()) {
      $response["status"] = "ok";
      $response["resourceType"] = $patient->resourceType;
      $response["user_id"] = $patient->user_id;
      $response["identifier"]["system"] = $patient->identifier_system;
      $response["identifier"]["value"] = $patient->identifier_value;
      $response["identifier"]["medicalId"] = $patient->medicalId;
      $response["name"] = $patient->name;
      $response["gender"] = $patient->gender;
      $response["birthDate"] = $patient->birthDate;
      $response["height"] = $patient->height;
      $response["weight"] = $patient->weight;
      $response["stepSize"] = $patient->stepSize;


      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    } else {
      $response["status"] = "error";

      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    }
  }
}
