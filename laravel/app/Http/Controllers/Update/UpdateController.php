<?php
namespace App\http\Controllers\Update;

use Illuminate\Routing\Controller;

/**
 * 返回 json 包含 软件更新 date version locate
 */
class UpdateController extends Controller
{

  function update()
  {
    $response["o2"]["0"]["version"] = "0.6.4";
    $response["o2"]["0"]["hardware_version"] = "AA";
    $response["o2"]["0"]["model"] = "1611";
    $response["o2"]["0"]["region"] = "FDA";
    $response["o2"]["0"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/FDA_1611_AA_064.bin";

    $response["o2"]["1"]["version"] = "0.6.4";
    $response["o2"]["1"]["hardware_version"] = "BB";
    $response["o2"]["1"]["model"] = "1611";
    $response["o2"]["1"]["region"] = "FDA";
    $response["o2"]["1"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/FDA_1611_BB_064.bin";

    $response["o2"]["2"]["version"] = "0.6.4";
    $response["o2"]["2"]["hardware_version"] = "AA";
    $response["o2"]["2"]["model"] = "1611";
    $response["o2"]["2"]["region"] = "CE";
    $response["o2"]["2"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/CE_1611_AA_064.bin";

    $response["o2"]["3"]["version"] = "0.6.4";
    $response["o2"]["3"]["hardware_version"] = "BB";
    $response["o2"]["3"]["model"] = "1611";
    $response["o2"]["3"]["region"] = "CE";
    $response["o2"]["3"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/CE_1611_BB_064.bin";

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}


 ?>
