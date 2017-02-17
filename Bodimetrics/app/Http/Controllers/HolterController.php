<?php

namespace App\Http\Controllers;

set_time_limit(0);

use Storage;

use PDF;
/**
* export holter pdf
*/
class HolterController extends Controller
{
  
  function __construct()
  {
    # code...
  }

  function export($holter_id)
  {
    $file = "/var/www/laravel/storage/attachments/20170604115306";
    $len = filesize($file);

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

    // page, every 30min, 125x30sx60x1.25=281250
    $pages = ceil(($len-32767)/281250);
    for ($i=0; $i < $pages; $i++) { 
      //image
      $image = imagecreatetruecolor(4200, 6400);

      $font = '/var/www/laravel/storage/fonts/consola.ttf';

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
      $pagetext = "Page: " . $i . "/" . $pages;
      imagefttext($image, 100, 0, 3800, 6200, $black, $font, $pagetext);
      imagefttext($image, 100, 0, 3800, 100, $black, $font, 'Record date: 04-Jun-2016');

      //plot
      for ($k=0; $k < 4*$dotNum-1; $k++) { 
        $x1 = $k%(3750) + 400;
        $y1 = (50-$dot[$k]) + intval($k/3750)*100 + 200;
        $x2 = ($k+1)%(3750) + 400;
        $y2 = (50-$dot[$k+1]) + intval(($k+1)/3750)*100 + 200;
        // imagesetpixel($image, $dotx[$k], $doty[$k], $black);
        // draw !wrap
        if (($k+1)%3750) {
          imagelinethick($image, $x1, $y1, $x2, $y2, $black, 2);
        }

        //time         
      }

      // header("Content-type: image/png");
      // imagepng($image);

      imagejpeg($image, "/var/www/laravel/storage/attachments/".$i.".jpg", 25);
      imagedestroy($image);

    }
  
  }

  function pdf()
  {
    $html = '';
    for ($l=0; $l < 30; $l++) { 
      $html .= '<div><img src="/var/www/laravel/storage/attachments/' . $l . '.png"></div>';
    }
    $pdf =  PDF::loadHTML($html)->save('/var/www/laravel/storage/attachments/.pdf');
    // return response()->file($file . '.pdf', $file_name . 'pdf');
    // return $html;
    return "ok";
  }

  
}