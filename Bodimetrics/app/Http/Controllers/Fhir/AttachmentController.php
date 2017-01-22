<?php

namespace App\Http\Controllers\Fhir;

set_time_limit(0);

use Auth;
use Illuminate\Http\Request;
use Storage;
use App\Observation_attachment;
use Illuminate\Routing\Controller;
use App\Observation;
use App\Observation_component;
use PDF;
use App\Patient;

/**
* upload attachment
*/
class AttachmentController extends Controller
{

  function upload(Request $request)
  {
    $user = Auth::user();
    $user_id = $user->id;

    $attachment = $request->attachment;
    $patient_id = $request->patient_id;
    $device_sn = $request->device_sn;
    $identifier_value = $request->identifier_value;
    $record_time = $request->record_time;
    $holter = $request->file('holter');

    $timestring = date_create($record_time);
    $file_name = date_format($timestring, 'YmdHis');

    //upload success
    if ($holter->isValid()) {
      Storage::put($patient_id . '/' . $file_name, file_get_contents($holter));

      //MySQL
      $sql_atmt = Observation_attachment::firstOrNew([
        'user_id' => $user_id,
        'identifier_value' => $identifier_value
        ]);

      $sql_atmt->patient_id = $patient_id;
      $sql_atmt->device_sn = $device_sn;
      $sql_atmt->record_time = $record_time;

      $sql_atmt->save();

      if ($query = Observation::where('patient_id', $patient_id)
                              ->where('identifier_value', $identifier_value)->first()) {
        $response["status"] = "ok";
        $response["patient_id"] = $patient_id;
        $response["observation_id"] = $query->id;
        $response["attachment_id"] = $sql_atmt->id;

        return response($response)
          ->header('Content-Type', 'application/json+fhir')
          ->header('Location', 'http://cloud.bodimetrics.com/observation/' . $query->id);
      }
      //create observation resource
      $observation = new Observation;

      $observation->user_id = $user_id;
      $observation->patient_id = $patient_id;
      $observation->resourceType = 'Observation';
      $observation->resourceId = 'ECG Holter';
      $observation->identifier_system = 'https://cloud.viatomtech.com/fhir';
      $observation->identifier_value = $identifier_value;
      $observation->category_system = 'http://hl7.org/fhir/observation-category';
      $observation->category_code = 'vital-signs';
      $observation->category_display = 'Vital Signs';
      $observation->code_system = 'https://cloud.viatomtech.com/fhir';
      $observation->code_code = '170105';
      $observation->code_display = 'ECG Holter';
      $observation->subject_reference = $patient_id;
      // $observation->subject_display = $observationData->subject->display;
      $observation->effectiveDateTime = $record_time;
      $observation->device_sn = $device_sn;
      $observation->device_display = 'Bodimetrics Pro';

      $observation->save();

      $observation_id = $observation->id;

      $observation_component = new Observation_component;

      $observation_component->observation_id = $observation_id;
      $observation_component->code_system = 'https://cloud.viatomtech.com/fhir';
      $observation_component->code_code = '170105';
      $observation_component->code_display = 'ECG Holter';
      $observation_component->valueAttachment = $sql_atmt->id;

      $observation_component->save();


      $response["status"] = "ok";
      $response["patient_id"] = $patient_id;
      $response["observation_id"] = $observation_id;
      $response["attachment_id"] = $sql_atmt->id;

      return response($response)
          ->header('Content-Type', 'application/json+fhir');
    } else {
      $response["status"] = "error";
      $response["error"] = "File is broken.";

      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    }
  }

  function download($attachment_id){
    $attach = Observation_attachment::findOrFail($attachment_id);

    $patient_id = $attach->patient_id;
    $time = date_create($attach->record_time);

    $patient = Patient::find($patient_id);
    $name = $patient->name;
    $medical_id = $patient->medicalId;

    $file_name = date_format($time, 'YmdHis');
    $dir = '/var/www/bodimetrics/storage/attachment/' . $patient_id;
    $file = $dir . '/' . $file_name;
    $len = filesize($file);

    $font = '/var/www/bodimetrics/storage/fonts/consola.ttf';

    //是否存在
    if (file_exists($file . '.pdf')) {
      return response()->download($file . '.pdf', $file_name . 'pdf');
    }
    
    function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1)
    {
      if ($thick == 1) {
          return imageline($image, $x1, $y1, $x2, $y2, $color);
      }
      $t = $thick / 2 - 0.5;
      if ($x1 == $x2 || $y1 == $y2) {
          return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
      }
      $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
      $a = $t / sqrt(1 + pow($k, 2));
      $points = array(
          round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
          round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
          round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
          round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
      );
      imagefilledpolygon($image, $points, 4, $color);
      return imagepolygon($image, $points, 4, $color);
    }

    $pages = ceil(($len-32767)/281250);
    for ($i=0; $i < $pages; $i++) { 
      //image
      $image = imagecreatetruecolor(4400, 6400);


      $black = imagecolorallocate($image, 0, 0, 0);
      $white = imagecolorallocate($image, 255, 255, 255);
      imagefill($image, 0, 0, $white);

      //start from 0x8000
      $content = file_get_contents($file, false, NULL, 32768+$i*281250, 281250);
      $arr = unpack("C*", $content);

      $dotNum = count($arr)/5;

      // set value
      for ($j=0; $j < $dotNum; $j++) { 
        $n0 = (($arr[5*$j + 5]) << 8) + $arr[5*$j + 1];
        $n1 = (($arr[5*$j + 5] >> 2) << 8) + $arr[5*$j + 2];
        $n2 = (($arr[5*$j + 5] >> 4) << 8) + $arr[5*$j + 3];
        $n3 = (($arr[5*$j + 5] >> 6) << 8) + $arr[5*$j + 4];

        // 第十位为1，前面补1， 第十位为0，前面全置为0
        if ($n0 & 512) {
          $n0 = ($n0 | 64512) - 65536;
        } else {
          $n0 = $n0 & 1023;
        }
        if ($n1 & 512) {
          $n1 = ($n1 | 64512) - 65536;
        } else {
          $n1 = $n1 & 1023;
        }
        if ($n2 & 512) {
          $n2 = ($n2 | 64512) - 65536;
        } else {
          $n2 = $n2 & 1023;
        }
        if ($n3 & 512) {
          $n3 = ($n3 | 64512) - 65536;
        } else {
          $n3 = $n3 & 1023;
        }

        $dot[4*$j] = $n0;
        $dot[4*$j+1] = $n1;
        $dot[4*$j+2] = $n2;
        $dot[4*$j+3] = $n3;
      }

      //page
      $pagetext = "Page: " . ($i+1) . "/" . $pages;
      imagefttext($image, 50, 0, 3800, 6250, $black, $font, $pagetext);
      imagefttext($image, 50, 0, 3490, 120, $black, $font, 'Record time: ' . date_format($time, 'd-M-Y'));
      imagefttext($image, 50, 0, 600, 120, $black, $font, 'Name:' . $name . '   Medical ID:' . $medical_id);

      // time
      for ($m=0; $m < (4*$dotNum-1)/3750/2; $m++) { 
        // $time+(30*$i+$m)*60)
        $linetime = date('H:i', strtotime($attach->record_time . '+' . (30*$i+$m) . 'minute'));
        imagefttext($image, 30, 0, 480, 250 + 200*$m, $black, $font, $linetime);
      }

      //plot
      for ($k=0; $k < 4*$dotNum-1; $k++) { 
        $x1 = $k%(3750) + 600;
        $y1 = (50-$dot[$k]) + intval($k/3750)*100 + 200;
        $x2 = ($k+1)%(3750) + 600;
        $y2 = (50-$dot[$k+1]) + intval(($k+1)/3750)*100 + 200;
        // imagesetpixel($image, $dotx[$k], $doty[$k], $black);
        // draw !wrap
        if (($k+1)%3750) {
          imagelinethick($image, $x1, $y1, $x2, $y2, $black, 2);
        }

        //time         
      }

      imagepng($image, $file.'_'.$i.".png");
      imagedestroy($image);
    }

    // generate PDF
    $html = '';
    for ($l=0; $l < $pages; $l++) { 
      $html .= '<div><img src="' . $file . '_' . $l . '.png"></div>';
    }
    $pdf =  PDF::loadHTML($html)->save($file . '.pdf');
    return response()->download($file . '.pdf');
    // return $html;
    // return "ok";

  }
}