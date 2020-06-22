<?php

namespace App\Http\Controllers\Ad;

use Illuminate\Routing\Controller;

/**
 * for ad apis
 * upload: device type, branchCode, location, language
 * response: showAd, imgSrc, link, interval
 */
class AdController extends Controller
{
    // for vihealth ads
    public function vihealth() {
        $upData = file_get_contents("php://input");
        $upJson = json_decode($upData);

        if (empty($upData) || empty($upJson)) {
            $res["status"] = "error";
            $res["error"] = "invalid data";

            return response($res)
                ->header('Content-Type', 'application/json');
        }

        /**
         * customize ad
         */
        $device = $upJson->device;
        $code = $upJson->branchCode;

        $adsJson = '[
                    {
                        "name": "Babytone",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_babytone.jpg",
                        "ad_src": "https://getwellue.com/pages/babytone-fetal-heart-monitor"
                    },
                    {
                        "name": "Checkme Pro",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_checkme_pro.jpg",
                        "ad_src": "https://getwellue.com/pages/checkme-pro-vital-signs-monitor"
                    },
                    {
                        "name": "Pulsebit EX",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_pulsebit_ex.jpg",
                        "ad_src": "https://getwellue.com/pages/pulsebit-ex-ekg-monitor"
                    },
                    {
                        "name": "O2Ring",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_ringo2.jpg",
                        "ad_src": "https://getwellue.com/pages/o2ring-oxygen-monitor"
                    },
                    {
                        "name": "OxySmart",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_oxy_smart.jpg",
                        "ad_src": "https://getwellue.com/pages/oxysmart-fingertip-pulse-oximeter"
                    },
                    {
                        "name": "Oxis",
                        "ad_img": "https://cloud.viatomtech.com/download/imgs/ad/ad_oxis.jpg",
                        "ad_src": "https://getwellue.com/"
                    }
                ]';

        $ads = json_decode($adsJson);
        $num = count($ads);
        $index = mt_rand(0, $num-1);

        $ad = $ads[$index];

        $show_ad = 1;
        $ad_img = $ad->ad_img;
        $ad_link = $ad->ad_src;
        if ($device =="snoreo2") {
            $show_ad = 0;
        }

        // lookee
        if ($code == null || $code == 23010001 || $code == 23020001 || $code == 15060001) {
            $show_ad = 0;
        }


        $res["status"] = "ok";
        $res["showAd"] = $show_ad;
        
        $res["imgSrc"] = $ad_img;
        $res["link"] = $ad_link;
        $res["interval"] = 0;  // 1 day
        $res["debug"] = $device . " - " . $code . " - " . $upJson->location . " - " . $upJson->language;

        return response($res)
            ->header('Content-Type', 'application/json');
    }
}
