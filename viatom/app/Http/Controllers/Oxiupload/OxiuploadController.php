<?php
namespace App\Http\Controllers\Oxiupload;

use Illuminate\Routing\Controller;
use Auth;
use App\Device;
use App\User;
use App\Oxiupload;


/**
 * Oxiupload -- device
 */
class OxiuploadController extends Controller
{

	
	
	public function Create()
	{
		$user = Auth::user();
		$user_id = $user->id;

		$dataJson = file_get_contents("php://input");
		$data = json_decode($dataJson);

		if (empty($dataJson) || empty($data)) {
			$response["status"] = "error";
			$response["error"] = "data error";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		$device = Device::where([
			'user_id' => $user_id,
			'device_name' => $data->device->name,
			'device_sn' => $data->device->sn
		])->first();

		if (!$device) {
			$response["status"] = "error";
			$response["error"] = "device not exists";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		$dt = strtotime($data->resourceDetail->recordDate);

		$oxiData = Oxiupload::firstOrNew([
			'device_id' => $device->id,
			'record_date' => date("Y-m-d h:i:sa", $dt)
		]);

		$oxiData->user_id = $user_id;
		$oxiData->resource_type = $data->resourceType;
		$oxiData->resource_version = $data->resourceVersion;
		$oxiData->record_duration = $data->resourceDetail->recordDuration;
		$oxiData->device_name = $data->device->name;
		$oxiData->device_sn = $data->device->sn;
		$oxiData->resource_data = $data->resourceData;
		$oxiData->resource_note = $data->resourceNote;

		$oxiData->save();


		$response["status"] = "ok";
		$response["userId"] = $user_id;
		$response["deviceId"] = $device->id;
		$response["resourceId"] = $oxiData->id;
		

		return response($response)
			->header('Content-Type', 'application/json');

	}

	public function QuerybyUser()
	{
		$user = Auth::user();
		$user_id = $user->id;

		$oxiDatas = Oxiupload::where('user_id', $user_id)->paginate(30);

		$resourceList = [];

		foreach ($oxiDatas as $oxiData) {
			$resource['deviceId'] = $oxiData->device_id;
			$resource['deviceName'] = $oxiData->device_name;
			$resource['deviceSn'] = $oxiData->device_sn;
			$resource['recordDate'] = $oxiData->record_date;
			$resource['resourceId'] = $oxiData->id;

			$resourceList[] = $resource;
		}


		$response["status"] = "ok";
		$response["total"] = $oxiDatas->total();
		$response["count"] = $oxiDatas->count();
		$response["from"] = $oxiDatas->firstItem();
		$response["to"] = $oxiDatas->lastItem();
		$response["hasMore"] = $oxiDatas->hasMorePages();
		$response["perPage"] = $oxiDatas->perPage();
		$response["currentPage"] = $oxiDatas->currentPage();
		$response["userId"] = $user_id;
		$response["resouceList"] = $resourceList;
		return response($response)
			->header('Content-Type', 'application/json');
	}

	public function QuerybyDevice($device_id)
	{
		$user = Auth::user();
		$user_id = $user->id;

		$device = Device::find($device_id);

		if (!$device) {
			$response["status"] = "error";
			$response["error"] = "device not exists";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		if ($device->user_id != $user_id) {
			$response["status"] = "error";
			$response["error"] = "unauthorized";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		$oxiDatas = Oxiupload::where('device_id', $device_id)->paginate(30);

		$resourceList = [];

		foreach ($oxiDatas as $oxiData) {
			$resource['deviceId'] = $oxiData->device_id;
			$resource['deviceName'] = $oxiData->device_name;
			$resource['deviceSn'] = $oxiData->device_sn;
			$resource['recordDate'] = $oxiData->record_date;
			$resource['resourceId'] = $oxiData->id;

			$resourceList[] = $resource;
		}


		$response["status"] = "ok";
		$response["total"] = $oxiDatas->total();
		$response["count"] = $oxiDatas->count();
		$response["from"] = $oxiDatas->firstItem();
		$response["to"] = $oxiDatas->lastItem();
		$response["hasMore"] = $oxiDatas->hasMorePages();
		$response["perPage"] = $oxiDatas->perPage();
		$response["currentPage"] = $oxiDatas->currentPage();
		$response["userId"] = $user_id;
		$response["deviceId"] = $device_id;
		$response["resouceList"] = $resourceList;

		return response($response)
			->header('Content-Type', 'application/json');
	}

	public function ResourceInfo($resource_id)
	{
		$user = Auth::user();
		$user_id = $user->id;

		$oxiData = Oxiupload::find($resource_id);

		if (!$oxiData) {
			$response["status"] = "error";
			$response["error"] = "data not exists";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		if ($oxiData->user_id != $user_id) {
			$response["status"] = "error";
			$response["error"] = "unauthorized";
			return response($response)
				->header('Content-Type', 'application/json');
		}

		$detail["recordDate"] = $oxiData->record_date;
		$detail["recordDuration"] = $oxiData->record_duration;
		$detail["note"] = $oxiData->resource_note;

		$device["name"] = $oxiData->device_name;
		$device["sn"] = $oxiData->device_sn;
		$device["id"] = $oxiData->device_id;

		$response["status"] = "ok";

		$response["resourceId"] = $oxiData->id;
		$response["resourceType"] = $oxiData->resource_type;
		$response["resourceVersion"] = $oxiData->resource_version;
		$response["resourceDetail"] = $detail;
		$response["device"] = $device;
		$response["resourceData"] = $oxiData->resource_data;
		$response["resourceNote"] = $oxiData->resource_note;

		return response($response)
			->header('Content-Type', 'application/json');
	}
}