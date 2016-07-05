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
    $response["o2"]["version"] = "0.2.6";
    $response["o2"]["hardware_version"] = "AA";
    $response["o2"]["model"] = "1611";
    $response["o2"]["region"] = "CE";
    $response["o2"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/CE_1611_AA_026.bin";

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}


 ?>
