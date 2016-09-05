<?php
namespace App\Http\Controllers\Fhir;

// error_reporting(0);

use App\Observation;
use App\Observation_component;
use App\Record;
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
    $user_id = $user->id;

    // return "upload success";

    $observationJson = file_get_contents("php://input");
    $observationData = json_decode($observationJson);

    // TODO: 当结果只有一个 component 时，单独放
    $component = $observationData->component;

    $id = $observationData->id; //其实是observation Type
    $identifier_value =$user_id . $observationData->identifier->value;

    // 判断是否已经上传
    if ($query = Observation::where('identifier_value', $identifier_value)->first()) {
      $response["user_id"] = $query->user_id;
      $response["observation_id"] = $query->id;
      $response["status"] = "generated";

      return response($response)
        ->header('Content-Type', 'application/json+fhir')
        ->header('Location', 'http://api.viatomtech.com.cn/observation/' . $query->id);
    }

    $subject_reference = $observationData->subject->reference; //这里其实是PatientId

    $observation = new Observation;

    $observation->user_id = $user_id;
    $observation->patient_id = $subject_reference;
    $observation->resourceType = $observationData->resourceType;
    $observation->resourceId = $observationData->id;
    $observation->identifier_system = $observationData->identifier->system;
    $observation->identifier_value = $identifier_value;
    $observation->category_system = $observationData->category->coding->system;
    $observation->category_code = $observationData->category->coding->code;
    $observation->category_display = $observationData->category->coding->display;
    $observation->code_system = $observationData->code->coding->system;
    $observation->code_code = $observationData->code->coding->code;
    $observation->code_display = $observationData->code->coding->display;
    $observation->subject_reference = $observationData->subject->reference;
    $observation->subject_display = $observationData->subject->display;
    $observation->effectiveDateTime = $observationData->effectiveDateTime;
    $observation->interpretation_system = $observationData->interpretation->coding->system;
    $observation->interpretation_code = $observationData->interpretation->coding->code;
    $observation->interpretation_display = $observationData->interpretation->coding->display;
    $observation->interpretation_text = $observationData->interpretation->text;

    $observation->save();
    // 查询上传的observation_id

    $observation_id = Observation::where('identifier_value', "$identifier_value")->first()->id;

    $com_num = count($component);
    for ($i=0; $i < $com_num; $i++) {

      $observation_component = new Observation_component;
      $observation_component->observation_id = $observation_id;
      $observation_component->code_system = $component[$i]->code->coding->system;
      $observation_component->code_code = $component[$i]->code->coding->code;
      $observation_component->code_display = $component[$i]->code->coding->display;

      if (array_key_exists("valueQuantity",$component[$i])) {

        $observation_component->valueQuantity_value = $component[$i]->valueQuantity->value;
        $observation_component->valueQuantity_unit = $component[$i]->valueQuantity->unit;
        $observation_component->valueQuantity_system = $component[$i]->valueQuantity->system;
        $observation_component->valueQuantity_code = $component[$i]->valueQuantity->code;

      } else {
        $observation_component->valueString = $component[$i]->valueString;
      }

      $observation_component->save();
    }

    $record = new Record;
    $record->user_id = $user_id;
    $record->patient_id = $subject_reference;
    $record->observation_id = $observation_id;
    $record->observationType = $id;
    $record->save();

    $response["user_id"] = "$user_id";
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
