<?php
namespace App\http\Controllers\Update;

use Illuminate\Routing\Controller;

/**
*
*/
class AppupdateConstroller extends Controller
{

  function app($os, $app) {
    $response;
    switch ($os) {
      case 'android':
        switch ($app) {
          //O2 Vibe
          case 'O2Vibe':
            $response["os"] = "android";
            $response["appName"] = "O2Vibe";
            $response["version"] = "2.0.0";
            $response["note"] = "Please update to version 2.0.0";
            $response["flag"] = "1";
            break;

          // CE O2
          case 'CheckO2':
            $response["os"] = "android";
            $response["appName"] = "CheckO2";
            $response["version"] = "2.0.0";
            $response["note"] = "Please update to version 2.0.0";
            $response["flag"] = "1";
            break;

          // SnoreO2
          case 'SnoreO2':
            $response["os"] = "android";
            $response["appName"] = "SnoreO2";
            $response["version"] = "1.3.0";
            $response["note"] = "Please update to version 1.3.0";
            $response["flag"] = "1";
            break;

          case 'cnsnoreo2':
            $response["os"] = "android";
            $response["appName"] = "SnoreO2";
            $response["version"] = "1.0.3";
            $response["note"] = "Please update to version 1.3.0";
            $response["flag"] = "1";
            break;

          default:
            # code...
            break;
        }
        break;
      case 'ios':
        switch ($app) {
          //O2 Vibe
          case 'O2Vibe':
            $response["os"] = "ios";
            $response["appName"] = "O2Vibe";
            $response["version"] = "2.0.3";
            $response["note"] = "Please update to version 2.0.3";
            $response["flag"] = "1";
            break;

          // CE O2
          case 'CheckO2':
            $response["os"] = "ios";
            $response["appName"] = "CheckO2";
            $response["version"] = "2.0.0";
            $response["note"] = "Please update to version 2.0.0";
            $response["flag"] = "1";
            break;

          // SnoreO2
          case 'SnoreO2':
            $response["os"] = "ios";
            $response["appName"] = "SnoreO2";
            $response["version"] = "1.3.0";
            $response["note"] = "Please update to version 1.3.0";
            $response["flag"] = "1";
            break;

          case 'cnsnoreo2':
            $response["os"] = "ios";
            $response["appName"] = "SnoreO2";
            $response["version"] = "1.3.0";
            $response["note"] = "Please update to version 1.3.0";
            $response["flag"] = "1";
            break;

          default:
            # code...
            break;
        }
        break;
      case 'pc':
        switch ($app) {
          case 'pulsebit':
            $response["os"] = "win";
            $response["appName"] = "pulsebit_browser_PRO";
            $response["version"] = "1.1.0";
            $response["note"] = "Updated at 2020-05-08";
            $response["flag"] = "1";
            $response['targetSrc'] = 'https://www.welluehealth.com/pc-software';
            break;
          
          default:
            # code...
            break;
        }
        break;
      case 'mac':
        switch ($app) {
          case 'pulsebit':
            $response["os"] = "mac";
            $response["appName"] = "pulsebit_browser_PRO";
            $response["version"] = "1.0.0";
            $response["note"] = "Updated at 2020-05-08";
            $response["flag"] = "1";
            $response['targetSrc'] = 'http://apps.apple.com/us/app/pulsebit-browser-pro/id1495286208?mt=12';
            break;
          
          default:
            # code...
            break;
        }
        break;
      default:
        # code...
        break;
    }

    return response($response)
      ->header('Content-Type', 'application/json');
  }
}

?>
