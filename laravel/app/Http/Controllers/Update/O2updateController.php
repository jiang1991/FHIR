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
	*@param form-data: isLive, snMin, snMax, btlVersion, btlLocate, appVersion, appLocate, releaseNote
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
		// {
		// 	"deviceName": "sleepo2",
		// 	"os": "android",
		// 	"appVersion": "2.4.10",
		// 	"sn": 1700000000,
		// 	"deviceBtlVersion": "1.0.0",
		// 	"deviceAppVersion": "2.2.0"
		// }

		$info =  json_decode(file_get_contents("php://input"));

		// query
		$query = Update_version::where("isLive", 1)
					->where("snMin", '<=', $info->sn)
					->where("snMax", '>=', $info->sn)
					->orderBy('id', 'desc')
					->first();

		// $query = Update_version::findOrFail(3);


		// $response["id"] = $query->id;
		$response["btlVersion"] = $query->btlVersion;
		$response["btlLocate"] = $query->btlLocate;
		$response["appVersion"] = $query->appVersion;
		$response["appLocate"] = $query->appLocate;
		$response["releaseNote"] = $query->releaseNote;
		return response($response)
			->header('Content-Type', 'application/json+fhir');
	}
}

?>