<?php
namespace App\http\Controllers\Update;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 返回 json 包含 软件更新 date version locate
 */
class UpdateController extends Controller
{

  /* O2 */
  function update()
  {

// FDA
    $response["o2"]["0"]["version"] = "2.2.0";
    $response["o2"]["0"]["hardware_version"] = "AA";
    $response["o2"]["0"]["model"] = "1611";
    $response["o2"]["0"]["region"] = "FDA";
    $response["o2"]["0"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/FDA_1611_CC_220.bin";

    $response["o2"]["1"]["version"] = "2.2.0";
    $response["o2"]["1"]["hardware_version"] = "BB";
    $response["o2"]["1"]["model"] = "1611";
    $response["o2"]["1"]["region"] = "FDA";
    $response["o2"]["1"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/FDA_1611_CC_220.bin";

    $response["o2"]["2"]["version"] = "2.2.0";
    $response["o2"]["2"]["hardware_version"] = "CC";
    $response["o2"]["2"]["model"] = "1611";
    $response["o2"]["2"]["region"] = "FDA";
    $response["o2"]["2"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/FDA_1611_CC_220.bin";
    
// CE
    $response["o2"]["3"]["version"] = "2.2.0";
    $response["o2"]["3"]["hardware_version"] = "AA";
    $response["o2"]["3"]["model"] = "1611";
    $response["o2"]["3"]["region"] = "CE";
    $response["o2"]["3"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/CE_1611_CC_220.bin";

    $response["o2"]["4"]["version"] = "2.2.0";
    $response["o2"]["4"]["hardware_version"] = "BB";
    $response["o2"]["4"]["model"] = "1611";
    $response["o2"]["4"]["region"] = "CE";
    $response["o2"]["4"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/CE_1611_CC_220.bin";

    $response["o2"]["5"]["version"] = "2.2.0";
    $response["o2"]["5"]["hardware_version"] = "CC";
    $response["o2"]["5"]["model"] = "1611";
    $response["o2"]["5"]["region"] = "CE";
    $response["o2"]["5"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/CE_1611_CC_220.bin";

//JP
    $response["o2"]["6"]["version"] = "2.6.0";
    $response["o2"]["6"]["hardware_version"] = "AA";
    $response["o2"]["6"]["model"] = "1611";
    $response["o2"]["6"]["region"] = "JP";
    $response["o2"]["6"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/NCI_2.6.0.bin";

    $response["o2"]["7"]["version"] = "2.6.0";
    $response["o2"]["7"]["hardware_version"] = "BB";
    $response["o2"]["7"]["model"] = "1611";
    $response["o2"]["7"]["region"] = "JP";
    $response["o2"]["7"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/NCI_2.6.0.bin";

    $response["o2"]["8"]["version"] = "2.6.0";
    $response["o2"]["8"]["hardware_version"] = "CC";
    $response["o2"]["8"]["model"] = "1611";
    $response["o2"]["8"]["region"] = "JP";
    $response["o2"]["8"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/NCI_2.6.0.bin";

// beta
    $response["o2"]["9"]["version"] = "2.2.0";
    $response["o2"]["9"]["hardware_version"] = "CC";
    $response["o2"]["9"]["model"] = "1611";
    $response["o2"]["9"]["region"] = "beta";
    $response["o2"]["9"]["fileLocate"] = "http://api.viatomtech.com.cn/download/software/O2/FDA_1611_CC_220.bin";

    return response($response)
      ->header('Content-Type', 'application/json');
  }

  /* CheckO2 & O2 Vibe */
  function O2Update($region) {
    switch ($region) {
        /* O2 Vibe */

        // O2 vibe fileVersion <= 3
        case "us_ver_3-":
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_btl_0.1.0.zip";
            $res['Firmware']['version'] = "4.1.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_app_4.1.0.zip";
            $res['note'] = "Release Note:\nPlease update to this version!";
            break;

        /* CE */
        case 'ce':
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/CheckO2_btl_0.1.0.zip";
            $res['Firmware']['version'] = "4.1.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/CheckO2_app_4.1.0.zip";
            $res['note'] = "Release Note:\nPlease update to this version!";
            break;

        // Sleep O2
        case 'sleepo2-':
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sleepo2/SleepO2_btl_0.1.0.zip";
            $res['Firmware']['version'] = "0.0.1";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sleepo2/SleepO2_app_4.1.5.zip";
            $res['note'] = "Release Note:\nPlease update to this version!";
            break;

        case 'o2ring':
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sleepo2/SleepO2_btl_0.1.0.zip";
            $res['Firmware']['version'] = "0.0.1";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sleepo2/SleepO2_app_4.3.0.zip";
            $res['note'] = "Release Note:\nPlease update to this version!";
            break;
        
        // default:
        //     $res['Bootloader']['version'] = "0.1.0";
        //     $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_btl_0.1.0.zip";
        //     $res['Firmware']['version'] = "4.1.5";
        //     $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_app_4.1.0.zip";
        //     // $res['Firmware']['version'] = "3.3.0";
        //     // $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_app_3.3.0.zip";
        //     $res['note'] = "Release Note:\nPlease update to this version!";
        //     break;
    }

    return response($res)
      ->header('Content-Type', 'application/json');
  }

  /* Bodimetrics Plus */
  function bodimetrics($hv)
  {
    switch ($hv) {
        
        default:
            $res['version'] = "2.3.0";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/bodimetrics/230/app_aes.bin";
            $res['language']['English/Spanish'] = "https://api.viatomtech.com.cn/download/software/bodimetrics/230/lang_aes.bin";
            break;
    }

    return response($res)
      ->header('Content-Type', 'application/json');
  }


  /* VitalsRx */
  function fda($hv){
    switch ($hv) {
        case 'beta':
            $res['version'] = "2.1.16";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/fda/2116/app_aes.bin";
            $res['language']['English'] = "https://api.viatomtech.com.cn/download/software/fda/2116/lang_aes.bin";
            break;
        
        default:
            $res['version'] = "2.1.15";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/fda/2116/app_aes.bin";
            $res['language']['English'] = "https://api.viatomtech.com.cn/download/software/fda/2116/lang_aes.bin";
            break;
    }
    

    return response($res)
      ->header('Content-Type', 'application/json');
  }

  /* Checkme CE */
  function ce($hv){

    // version info
    $version['version'] = "2.4.0";
    $version['fileLocate'] = "https://api.viatomtech.com.cn/download/software/ce/2.4.0/app_aes.bin";
    $version['language']['English'] = "https://api.viatomtech.com.cn/download/software/ce/2.4.0/lang_aes_en.bin";
    $version['language']['Simplified Chinese/Traditional Chinese/English'] = "https://api.viatomtech.com.cn/download/software/ce/2.4.0/lang_aes_en_cn_tc.bin";
    $version['language']['Spanish/German/French/Italian/English'] = "https://api.viatomtech.com.cn/download/software/ce/2.4.0/lang_aes_en_es_de_fr_it.bin";
    $version['language']['Polish/Russian/Hungarian/Czech/English'] = "https://api.viatomtech.com.cn/download/software/ce/2.4.0/lang_aes_en_po_ru_hu_cz.bin";
   
    /*upload json example
    {
    "Region":"HongKong",
    "Model":"6632",
    "Hardware":"EE",
    "Software":"20",
    "Language":"2"
    }*/
    $jsonStr = file_get_contents("php://input");
    if ($jsonStr != null) {
        $json = json_decode($jsonStr);
        $region = $json->Region;
        
        if ($region == "HongKong") {
            $res = "12321";
        } else {
            $res = $version;
        }
    } else {
        $res = $version;
    }

    return response($res)
      ->header('Content-Type', 'application/json');
  }

  /* JP Pro*/
  function jp($hv) {
    switch ($hv) {
        // Pro S
        case "pros":
            $res['version'] = "2.0.0";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sanei/pros/200/app_aes.bin";
            $res['language']['Japanese'] = "https://api.viatomtech.com.cn/download/software/sanei/pros/200/lang_aes_jp.bin";
            $res['language']['English'] = "https://api.viatomtech.com.cn/download/software/sanei/pros/200/lang_aes_en.bin";
            break;
        // Pro X
        case "prox":
            $res['version'] = "2.0.0";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sanei/prox/200/app_aes.bin";
            $res['language']['Japanese'] = "https://api.viatomtech.com.cn/download/software/sanei/prox/200/lang_aes_jp.bin";
            $res['language']['English'] = "https://api.viatomtech.com.cn/download/software/sanei/prox/200/lang_aes_en.bin";
            break;
        // Pro EX
        case "proadv":
            $res['version'] = "0.1.18";
            $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/sanei/proadv/0118/app_aes.bin";
            $res['language']['Japanese'] = "https://api.viatomtech.com.cn/download/software/sanei/proadv/0118/lang_aes.bin";
            //$res['language']['English'] = "https://api.viatomtech.com.cn/download/software/sanei/prox/200/lang_aes_en.bin";
            break;
        default:
            break;
    }

    return response($res)
        ->header('Content-Type', 'application/json');
  }


  // semacare
  function semacare($hv) {
    $res['version'] = "1.5.4";
    $res['fileLocate'] = "https://api.viatomtech.com.cn/download/software/semacare/153/app_aes.bin";
    $res['language']['English'] = "https://api.viatomtech.com.cn/download/software/semacare/153/lang_aes.bin";

    return response($res)
        ->header('Content-Type', 'application/json');
  }

  /* Smart BP */
  function smartbp($lang) {
    switch ($lang) {
        case 'ver_6':
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/smartbp/SmartBP_btl_0.1.0.zip";
            $res['Firmware']['version'] = "2.1.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/smartbp/SmartBP_app_2.1.0.zip";
            $res['note'] = "...";
            break;
        default:
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/smartbp/SmartBP_btl_0.1.0.zip";
            $res['Firmware']['version'] = "1.0.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/smartbp/SmartBP_app_1.0.0.zip";
            $res['note'] = "...";
            break;
    }

    return response($res)
        ->header('Content-Type', 'application/json');

  }

  /* Snore O2 */
  function snoreo2($lang) {
    switch ($lang) {
        case "en":
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/snoreo2/SnoreO2_btl_0.1.0.zip";
            $res['Firmware']['version'] = "2.6.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/snoreo2/SnoreO2_app_2.6.0.zip";
            $res['note'] = "The newest version is 2.6.0.";
            break;
        case "beta":
            $res['Bootloader']['version'] = "0.1.0";
            $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/snoreo2/SnoreO2_btl_0.1.0.zip";
            $res['Firmware']['version'] = "2.6.0";
            $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/snoreo2/SnoreO2_app_2.6.0.zip";
            $res['note'] = "The newest version is 2.6.0.";
            break;
        
        default:
            # code...
            break;
    }

    return response($res)
        ->header('Content-Type', 'application/json');
  }

  function test() {
    $res['Bootloader']['version'] = "0.0.2";
    $res['Bootloader']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_btl_0.0.2.zip";
    $res['Firmware']['version'] = "2.9.3";
    $res['Firmware']['fileLocate'] = "https://api.viatomtech.com.cn/download/software/checko2/O2Vibe_app_2.9.3.zip";
    $res['note'] = "The newest version is 2.9.3.";

    return response($res)
        ->header('Content-Type', 'application/json');
  }

  function apis($param) {
        // $res['note'] = "The newest version is 3.2.0.";

        // return date("Y-m-d H:i:s");
        return response(date("Y-m-d H:i:s"))
          ->header('Content-Type', 'application/json');
    }


}


 ?>
