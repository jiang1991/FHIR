<?php
namespace App\http\Controllers\Update;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
* 
*/
class RedirectController extends Controller
{
	
	function redirect($app_name, $os_name) {
		switch ($app_name) {
			// nci_o2
			case 'nci_o2':
				switch ($os_name) {
					case 'ios':
						$url = "https://itunes.apple.com/jp/app/ringo2/id1367041096?mt=8";
						break;
					case 'android':
						$url = "https://play.google.com/store/apps/details?id=com.viatom.ncio2";
						break;
					default:
						$url = "https://www.viatomtech.com";
						break;
				}
				break;
			
			// MyBeats Hub  -- Check Mobile
			case 'mybeatsplus':
				switch ($os_name) {
					case 'ios':
						$url = "https://apps.apple.com/app/id1499954763";
						break;
					case 'android':
						$url = "https://play.google.com/store/apps/details?id=com.yz.newazur";
						break;
					default:
						$url = "https://google.com";
						break;
				}
				break;

			// vihealth
			case 'welloxy':
				switch ($os_name) {
					case 'ios':
						$url = "https://itunes.apple.com/us/app/welloxy-mobile/id1457822098?l=zh&ls=1&mt=8";
						break;
					case 'android':
						$url = "https://play.google.com/store/apps/details?id=com.vtm.mbhealth";
						break;
					default:
						$url = "https://google.com";
						break;
				}
				break;

			// vihealth - 国内
			case 'vihealth_cn':
				switch ($os_name) {
					case 'ios':
						$url = "https://apps.apple.com/cn/app/vihealth/id1413644737?l=en";
						break;
					case 'android':
						$url = "https://api.viatomtech.com.cn/download/software/apk/vihealth_release_2.12.0.apk";
						break;
					default:
						$url = "https://api.viatomtech.com.cn/download/software/apk/vihealth_release_2.12.0.apk";
						break;
				}
				break;

			// bp tracker mobile -- airbp
			case 'bptracker':
				switch ($os_name) {
					case 'ios':
						$url = "https://itunes.apple.com/us/app/bp-tracker-mobile/id1453342390?l=zh&ls=1&mt=8";
						break;
					case 'android':
						$url = "https://play.google.com/store/apps/details?id=com.vtm.bptracker";
						break;
					default:
						$url = "https://google.com";
						break;
				}
				break;

			// new monitor -- mybeats air
			case 'mymonitor':
				switch ($os_name) {
					case 'ios':
						$url = "https://itunes.apple.com/us/app/mybeats-air/id1005495147?l=zh&ls=1&mt=8";
						break;
					case 'android':
						$url = "https://play.google.com/store/apps/details?id=com.yz.mybeats.air";
						break;
					default:
						$url = "https://google.com";
						break;
				}
				break;
			
			default:
				$url = "https://www.viatomtech.com";
				break;
		}

		return redirect($url);
	}

	function gettime() {
		$res['note'] = "The newest version is 3.2.0.";

		// return date("Y-m-d H:i:s");
		return response($res)
		  ->header('Content-Type', 'application/json');
	}

	function app_download($appname) {
		switch ($appname) {

			// 鼾畅氧环
			case 'hanchang':
				$url = "https://api.viatomtech.com.cn/download/software/apk/hanchang_release_V1.0.18.apk";
				break;

			case 'lepucare':
				$url = "http://app.appurl.me/79817901333";
				break;
			
			default:
				$url = "https://google.com";
				break;
		}

		return redirect($url);
	}
}

?>