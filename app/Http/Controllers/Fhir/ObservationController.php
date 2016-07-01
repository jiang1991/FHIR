<?php
namespace App\Http\Controllers\Fhir;

// error_reporting(0);

use App\Observation;
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

    // TODO: 当结果只有一个 component 时，单独放
    $category = $observationData->category->coding;
    $observationCode = $observationData->code->coding;
    $interpretation = $observationData->interpretation->coding;
    $component = $observationData->component;

    $resourceType = $observationData->resourceType;
    $id = $observationData->id; //其实是observation Type
    // TODO: 判断是否已经上传
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
    $result1 = DB::insert('INSERT INTO observations (resourceType, resourceId, identifier_system, identifier_value, category_system, category_code, category_display, code_system, code_code, code_display, subject_reference, subject_display, effectiveDateTime, interpretation_system, interpretation_code, interpretation_display, interpretation_text) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$resourceType, $id, $identifier_system, $identifier_value, $category_system, $category_code, $category_display, $code_system, $code_code, $code_display, $subject_reference, $subject_display, $effectiveDateTime, $interpretation_system, $interpretation_code, $interpretation_display, $interpretation_text]);

    // 查询上传的observation_id

    $observation_id = DB::table('observations')->WHERE('identifier_value', "$identifier_value")->first()->id;
    // echo json_encode($observation_id);

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

        $result2 = DB::insert('INSERT INTO observation_components (observation_id, code_system, code_code, code_display, valueQuantity_value, valueQuantity_unit, valueQuantity_system, valueQuantity_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [$observation_id, $componentCode_system, $componentCode_code, $componentCode_display, $valueQuantity_value, $valueQuantity_unit, $valueQuantity_system, $valueQuantity_code]);
      } else {
        $valueString = $component[$i]->valueString;

        $result2 = DB::table('observation_components')->insert([
          'observation_id' => "$observation_id",
          'code_system' => "$componentCode_system",
          'code_code' => "$componentCode_code",
          'code_display' => "$componentCode_display",
          'valueString' => "$valueString",
          ]);
      }

    }

    /*写入可被查询的record*/
    DB::table('records')->insert([
      'userId' => "$userId",
      'patientId' => "$subject_reference",
      'observation_id' => "$observation_id",
      'observationType' => "$id",
      ]);

    $response["userId"] = "$userId";
    $response["observation_id"] = "$observation_id";
    $response["status"] = "generated";

    return response($response)
      ->header('Content-Type', 'application/json+fhir')
      ->header('Location', 'http://api.viatomtech.com.cn/observation/' . $observation_id);
  }

  /*
  * Fhir Read
  * Read = GET https://example.com/path/{resourceType}/{id}
  */
  function ObservationRead($observation_id)
  {
    $query = Observation::findOrFail($observation_id);
    // TODO: effectiveDateTime or effectivePeriod
    $response["ResourceType"] = $query->resourceType;
    $response["id"] = $query->resourceId;
    $response["identifier"]["system"] = $query->identifier_system;
    $response["identifier"]["value"] = $query->identifier_value;
    $response["category"]["coding"]["system"] = $query->category_system;
    $response["category"]["coding"]["code"] = $query->category_code;
    $response["category"]["coding"]["display"] = $query->category_display;
    $response["code"]["coding"]["system"] = $query->code_system;
    $response["code"]["coding"]["code"] = $query->code_code;
    $response["code"]["coding"]["display"] = $query->code_display;
    $response["effectiveDateTime"] = $query->effectiveDateTime;
    $response["interpretation"]["coding"]["system"] = $query->interpretation_system;
    $response["interpretation"]["coding"]["code"] = $query->interpretation_code;
    $response["interpretation"]["coding"]["display"] = $query->interpretation_display;
    $response["interpretation"]["text"] = $query->interpretation_text;

    $Qcomponents = Observation::find($observation_id)->observation_components;
    $Qcomponent = $Qcomponents->toArray();

    $com_num = count($Qcomponent);
    for ($i=0; $i < $com_num; $i++) {
      $component["code"]["coding"]["system"] = $Qcomponent[$i]['code_system'];
      $component["code"]["coding"]["code"] = $Qcomponent[$i]['code_code'];
      $component["code"]["coding"]["display"] = $Qcomponent[$i]['code_display'];

      // valueQuantity 非空 ?
      if (!empty($Qcomponent[$i]['valueQuantity_value'])) {
        $component["valueQuantity"]["value"] = $Qcomponent[$i]['valueQuantity_value'];
        $component["valueQuantity"]["unit"] = $Qcomponent[$i]['valueQuantity_unit'];
        $component["valueQuantity"]["system"] = $Qcomponent[$i]['valueQuantity_system'];
        $component["valueQuantity"]["code"] = $Qcomponent[$i]['valueQuantity_code'];
      } else {
        $component["valueString"] = $Qcomponent[$i]['valueString'];
      }


      $response["component"][$i] = $component;
    }
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}
