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
			
			default:
				$url = "https://google.com";
				break;
		}

		return redirect($url);
	}
}

?>