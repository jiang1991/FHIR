<?php
namespace App\http\Controllers\Update;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Update_version;

/**
 * insert & query
 */
class O2updateController extends Controller
{
	/**
	*@param form-data: isLive, deviceName, snMin, snMax, btlVersion, btlLocate, appVersion, appLocate, releaseNote
	*
	*
	*/
	public function insert(Request $request) {
		# get 
		$isLive = $request->isLive;
		$deviceName = $request->deviceName;
		$snMin = $request->snMin;
		$snMax = $request->snMax;
		$btlVersion = $request->btlVersion;
		$appVersion = $request->appVersion;
		$releaseNote = $request->releaseNote;

		$version = new Update_version;
		$version->isLive = $isLive;
		$version->deviceName = $deviceName;
		$version->snMin = $snMin;
		$version->snMax = $snMax;
		$version->btlVersion = $btlVersion;
		$version->btlLocate = "123";
		$version->appVersion = $appVersion;
		$version->appLocate = "234";
		$version->releaseNote = $releaseNote;

		$version->save();

		$response["id"] = $version->id;
		$response["status"] = "ok";
		return response($response)
			->header('Content-Type', 'application/json+fhir');
	}

	public function query() {

		# example json
		/**
		{
			"deviceName": "sleepo2",
			"os": "android",
			"appVersion": "2.4.10",
			"sn": 1700000000,
			"deviceBtlVersion": "1.0.0",
			"deviceAppVersion": "2.2.0"
		}
		*/

		/** 
		ceo2
		snoreo2
		o2ring
		sleepo2
		wearo2
		sleepu
		o2vibe
		airbp
		er1
		er2
		oxylink
		kidso2
		*/

		if (!file_get_contents("php://input")) {
			$response['error'] = 'empty POST json';
			return response($response)
				->header('Content-Type', 'application/json+fhir');
		}

		$info =  json_decode(file_get_contents("php://input"));

		if (!$info) {
			$response['error'] = 'json error';
			$response['message'] = file_get_contents("php://input");
			return response($response)
				->header('Content-Type', 'application/json+fhir');
		}

		$sn_dec =  hexdec($info->sn);

		// query
		$query = Update_version::where("isLive", 1)
					->where("deviceName", $info->deviceName)
					->where("snMin", '<=', $sn_dec)
					->where("snMax", '>=', $sn_dec)
					->orderBy('id', 'desc')
					->first();

		// $query = Update_version::findOrFail(3);


		// $response["id"] = $query->id;
		$response['Bootloader']['version'] = $query->btlVersion;
		$response['Bootloader']['fileLocate'] = $query->btlLocate;
		$response['Firmware']['version'] = $query->appVersion;
		$response['Firmware']['fileLocate'] = $query->appLocate;
		$response["releaseNote"] = $query->releaseNote;
		return response($response)
			->header('Content-Type', 'application/json+fhir');
	}
}

?>