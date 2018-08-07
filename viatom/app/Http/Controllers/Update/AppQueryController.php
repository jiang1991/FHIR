<?php
namespace App\http\Controllers\Update;
use Illuminate\Routing\Controller;

/**
 * 
 */
class AppQueryController extends Controller
{
	function query() {

		function isNewVersion($curVersion, $comVersion) {
			$cur = explode('.', $curVersion);
			$comp = explode('.', $comVersion);

			if ($cur[0] < $comp[0]) {
				return true;
			} elseif ($cur[0] == $comp[0] && $cur[1] < $comp[1]) {
				return true;
			} elseif ($cur[0] == $comp[0] && $cur[1] == $comp[1] && $cur[2] < $comp[2]) {
				return ture;
			} else {
				return false;
			}
		}

		/* 
		* 强制升级 forceVersion
		* 低于此版本 提示升级 unforceVersion
		* 最新版本 newestVersion
		**/
		// android
		$ViHealth["android"]["forceVersion"] = "1.0.0";
		$ViHealth["android"]["unforceVersion"] = "1.0.0";
		$ViHealth["android"]["newestVersion"] = "1.0.0";
		$ViHealth["android"]["releaseNote"] = "V1.1.1\nWhenever you feel like criticizing any one\nV1.1.0\njust remember that\nV1.0.0";
		// ios
		$ViHealth["iOS"]["forceVersion"] = "0.0.1";
		$ViHealth["iOS"]["unforceVersion"] = "0.0.1";
		$ViHealth["iOS"]["newestVersion"] = "1.0.0";
		$ViHealth["iOS"]["releaseNote"] = "V2.1.1\nWhenever you feel like criticizing any one\nV2.1.0\njust remember that\nV2.0.0\n";


		$infoJson = file_get_contents("php://input");
		$info = json_decode($infoJson);


		$appName = $info->appName;
		$os = $info->os;
		$appVersion = $info->appVersion;
		$language = $info->language;

		$flag = 2;
		if (isNewVersion($appVersion, $ViHealth[$os]["forceVersion"])) {
			$flag = 0;
		} elseif (isNewVersion($appVersion, $ViHealth[$os]["unforceVersion"])) {
			$flag = 1;
		}

		$res["version"] = $ViHealth[$os]["newestVersion"];
		$res["releaseNote"] = $ViHealth[$os]["releaseNote"];
		$res["flag"] = $flag;

		return response($res)
      		->header('Content-Type', 'application/json');
	}
}