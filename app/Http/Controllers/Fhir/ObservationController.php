<?php
namespace App\Http\Controllers\Fhir;

// error_reporting(0);

use DB;
use Illuminate\Routing\Controller;
use Auth;


/**
* Observation
*/
class ObservationController extends Controller
{
  /*
  * Fhir Create
  * Create = POST https://example.com/path/{resourceType}
  */
  function ObservationCreate()
  {
    /*查询用户id*/
    $user = Auth::user();
    $userId = $user->id;

    // return "upload success";

    $observationJson = file_get_contents("php://input");
    $observationData = json_decode($observationJson);

    $category = $observationData->category->coding;
    $observationCode = $observationData->code->coding;
    $interpretation = $observationData->interpretation->coding;
    $component = $observationData->component;

    $resourceType = $observationData->resourceType;
    $id = $observationData->id; //其实是observation Type
    $identifier_system = $observationData->identifier->system;
    $identifier_value = $observationData->identifier->value;
    $category_system = $category->system;
    $category_code = $category->code;
    $category_display = $category->display;
    $code_system = $observationCode->system;
    $code_code = $observationCode->code;
    $code_display = $observationCode->display;
    $subject_reference = $observationData->subject->reference; //这里其实是PatientId
    $subject_display = $observationData->subject->display;
    $effectiveDateTime = $observationData->effectiveDateTime;
    $interpretation_system = $interpretation->system;
    $interpretation_code = $interpretation->code;
    $interpretation_display = $interpretation->display;
    $interpretation_text = $observationData->interpretation->text;

    // 写入Observation
    $result1 = DB::insert('INSERT INTO Observation (resourceType, id, identifier_system, identifier_value, category_system, category_code, category_display, code_system, code_code, code_display, subject_reference, subject_display, effectiveDateTime, interpretation_system, interpretation_code, interpretation_display, interpretation_text) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$resourceType, $id, $identifier_system, $identifier_value, $category_system, $category_code, $category_display, $code_system, $code_code, $code_display, $subject_reference, $subject_display, $effectiveDateTime, $interpretation_system, $interpretation_code, $interpretation_display, $interpretation_text]);

    // 查询上传的observationId

    $observationId = DB::table('Observation')->WHERE('identifier_value', "$identifier_value")->first()->observationId;
    // echo json_encode($observationId);

    $com_num = count($component);
    for ($i=0; $i < $com_num; $i++) {
      // valueQuantity or valueSampledData
      // 写入Observation Component
      $componentCode_system = $component[$i]->code->coding->system;
      $componentCode_code = $component[$i]->code->coding->code;
      $componentCode_display = $component[$i]->code->coding->display;

      if (array_key_exists("valueQuantity",$component[$i])) {
        $valueQuantity_value = $component[$i]->valueQuantity->value;
        $valueQuantity_unit = $component[$i]->valueQuantity->unit;
        $valueQuantity_system = $component[$i]->valueQuantity->system;
        $valueQuantity_code = $component[$i]->valueQuantity->code;

        $result2 = DB::insert('INSERT INTO Observation_component (observationId, code_system, code_code, code_display, valueQuantity_value, valueQuantity_unit, valueQuantity_system, valueQuantity_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [$observationId, $componentCode_system, $componentCode_code, $componentCode_display, $valueQuantity_value, $valueQuantity_unit, $valueQuantity_system, $valueQuantity_code]);
      } else {
        $valueSampledDataRate = $component[$i]->valueSampledData->samplingRate;
        $valueSampledDataAccuracy = $component[$i]->valueSampledData->samplingAccuracy;
        $valueSampledDataVoltage = $component[$i]->valueSampledData->referenceVoltage;
        $valueSampledDataData = $component[$i]->valueSampledData->data;

        $result2 = DB::table('Observation_component')->insert([
          'observationId' => "$observationId",
          'code_system' => "$componentCode_system",
          'code_code' => "$componentCode_code",
          'code_display' => "$componentCode_display",
          'valueSampledDataRate' => "$valueSampledDataRate",
          'valueSampledDataAccuracy' => "$valueSampledDataAccuracy",
          'valueSampledDataVoltage' => "$valueSampledDataVoltage",
          'valueSampledDataData' => "$valueSampledDataData",
          ]);
      }

    }

    /*写入可被查询的record*/
    DB::table('record')->insert([
      'userId' => "$userId",
      'patientId' => "$subject_reference",
      'observationId' => "$observationId",
      'observationType' => "$id",
      ]);

    $response["userId"] = "$userId";
    $response["observationId"] = "$observationId";
    $response["status"] = "generated";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'http://api.viatomtech.com.cn:8080/fhir/public/observation/' . $observationId);
  }

  /*
  * Fhir Read
  * Read = GET https://example.com/path/{resourceType}/{id}
  */
  function ObservationRead($observationId)
  {
    // TODO： 简化语法
    $query = DB::select('SELECT * FROM Observation WHERE observationId = :id', ['id' => $observationId]);
    // 这里应该判断是否存在并返回
    $response["ResourceType"] = $query["0"]->resourceType;
    $response["id"] = $query["0"]->id;
    $response["identifier"]["system"] = $query["0"]->identifier_system;
    $response["identifier"]["value"] = $query["0"]->identifier_value;
    $response["category"]["coding"]["system"] = $query["0"]->category_system;
    $response["category"]["coding"]["code"] = $query["0"]->category_code;
    $response["category"]["coding"]["display"] = $query["0"]->category_display;
    $response["code"]["coding"]["system"] = $query["0"]->code_system;
    $response["code"]["coding"]["code"] = $query["0"]->code_code;
    $response["code"]["coding"]["display"] = $query["0"]->code_display;
    $response["effectiveDateTime"] = $query["0"]->effectiveDateTime;
    $response["interpretation"]["coding"]["system"] = $query["0"]->interpretation_system;
    $response["interpretation"]["coding"]["code"] = $query["0"]->interpretation_code;
    $response["interpretation"]["coding"]["display"] = $query["0"]->interpretation_display;
    $response["interpretation"]["text"] = $query["0"]->interpretation_text;

    // TODO: 使用16进制数据，简化格式
    $query2 = DB::select('SELECT * FROM Observation_component WHERE observationId = :id', ['id' => $observationId]);
    $com_num = count($query2);
    for ($i=0; $i < $com_num; $i++) {
      $component["code"]["coding"]["system"] = $query2[$i]->code_system;
      $component["code"]["coding"]["code"] = $query2[$i]->code_code;
      $component["code"]["coding"]["display"] = $query2[$i]->code_display;

      // valueQuantity 非空 ?
      if (!empty($query2[$i]->valueQuantity_value)) {
        $component["valueQuantity"]["value"] = $query2[$i]->valueQuantity_value;
        $component["valueQuantity"]["unit"] = $query2[$i]->valueQuantity_unit;
        $component["valueQuantity"]["system"] = $query2[$i]->valueQuantity_system;
        $component["valueQuantity"]["code"] = $query2[$i]->valueQuantity_code;
      } else {
        $component["valueSampledData"]["samplingRate"] = $query2[$i]->valueSampledDataRate;
        $component["valueSampledData"]["samplingAccuracy"] = $query2[$i]->valueSampledDataAccuracy;
        $component["valueSampledData"]["referenceVoltage"] = $query2[$i]->valueSampledDataVoltage;
        $component["valueSampledData"]["data"] = $query2[$i]->valueSampledDataData;
      }


      $response["component"][$i] = $component;
    }

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
    // echo json_encode($result);
  }
}
