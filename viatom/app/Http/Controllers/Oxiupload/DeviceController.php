<?php
namespace App\Http\Controllers\Oxiupload;

use Illuminate\Routing\Controller;
use Auth;
use App\Device;
use App\User;

/**
 * Oxiupload -- device
 */
class DeviceController extends Controller
{

	public function create()
	{

		$user = Auth::user();
		$user_id = $user->id;

		$deviceJson = file_get_contents("php://input");
		$deviceData = json_decode($deviceJson);

		if (empty($deviceJson) || empty($deviceData)) {
			$response["status"] = "error";
			$response["error"] = "data error";
			return response($response)
				->header('Content-Type', 'application/json');
		}


		$device = Device::firstOrNew([
			'user_id' => $user_id,
			'device_name' => $deviceData->deviceName,
			'device_sn' => $deviceData->deviceSn
		]);

		$device->branch_code = $deviceData->branchCode;
		$device->btl_version = $deviceData->btlVersion;
		$device->app_version = $deviceData->appVersion;
		$device->file_version = $deviceData->fileVersion;
		$device->device_json = $deviceData->deviceJson;

		$device->save();

		$response["status"] = "ok";
		$response["userId"] = $user_id;
		$response["deviceId"] = $device->id;		
		
		return response($response)
			->header('Content-Type', 'application/json');
	}

	public function QuerybyUser()
	{
		$user = Auth::user();
		$user_id = $user->id;

		$devices = Device::where('user_id', $user_id)->get();
		$devicesSize = $devices->count();

		$deviceList = [];

		foreach ($devices as $d) {
			$device['id'] = $d->id;
			$device['name'] = $d->device_name;
			$device['sn'] = $d->device_sn;
			$device['branchCode'] = $d->branch_code;

			$deviceList[] = $device;
		}

		$response["status"] = "ok";
		$response["userId"] = $user_id;
		$response["deviceListSize"] = $devicesSize;
		$response["deviceList"] = $deviceList;
		
		return response($response)
			->header('Content-Type', 'application/json');
	}

	public function DeviceInfo($device_id)
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


		$response["status"] = "ok";
		
		$response["deviceId"] = $device->id;
		$response["deviceName"] = $device->device_name;
		$response["deviceSn"] = $device->device_sn;
		$response["branchCode"] = $device->branch_code;
		$response["btlVersion"] = $device->btl_version;
		$response["appVersion"] = $device->app_version;
		$response["fileVersion"] = $device->file_version;
		$response["deviceJson"] = $device->device_json;

		return response($response)
			->header('Content-Type', 'application/json');
	}

	
}