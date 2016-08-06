<?php
namespace App\Http\Controllers;

use App\Observation_component;

/**
 * return png
 */
class PlotController extends Controller
{
  public function Plot($id)
  {
    // 赋值
    $hexs = Observation_component::find($id)->valueString;


    /**
    *
    * draw a thick line
    */
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


    // ECG plot
    function EcgPlot($hexs)
    {
      // 对值进行处理
      function dec2px($hexs)
      {
        $hex = str_split($hexs, 4);

        $dot = [];
        $dots = [];

        for ($i=0; $i < count($hex); $i++) {
          if (strlen($hex[$i]) == 4) {
            /* 16进制 调换顺序 */
            $rev = str_split($hex[$i], 2);
            $dec = hexdec($rev[1] . $rev[0]);

            /* 最高位有符号位 */
            if ($dec > 32767) {
              $dot[$i] = $dec - 65536;
            } else {
              $dot[$i] = $dec;
            }
          }
        }

        /* 解压缩，还原为500Hz*/
        /* 采样值转px  X*4033/(32767*12*8)*400 */
        for ($i=0; $i < count($dot)-1; $i++) {
          $dots[] = 650 - $dot[$i] * 0.51238;
          $dots[] = 650 - ($dot[$i] + $dot[$i+1])/2 * 0.51238;
        }
        $dots[] = 650 - $dot[count($dot)-1] * 0.51238;

        return($dots);
      }


      $dots = dec2px($hexs);

      // 分割数据 多少行
      $dot = array_chunk($dots, 3500);
      $rows = count($dot);

      $width = 4000;
      $height = 800 * $rows + 500;

      $image = imagecreatetruecolor($width, $height);
      $white = imagecolorallocate($image, 255, 255, 255);
      $yellow = imagecolorallocate($image,255,255,0);
      $red    = imagecolorallocate($image,255,0,0);
      // $red2    = imagecolorallocate($image,255,0,0);
      $black   = imagecolorallocate($image,0,0,0);

      imagefill($image, 0, 0, $white);

      /**
      *背景框
      */
      for ($i=0; $i < 175; $i++) {
        imageline($image, $i * 20 + 250, 250, $i * 20 + 250, $rows * 800 + 250, $red);
      }
      for ($i=0; $i < 40 * $rows; $i++) {
        imageline($image, 250, $i * 20 + 250, 3500 + 250, $i * 20 + 250, $red);
      }

      for ($i=0; $i < 35; $i++) {
        imagelinethick($image, $i * 100 + 250, 250, $i * 100 + 250, $rows * 800 + 250, $red, 2);
      }
      for ($i=0; $i < 8 * $rows; $i++) {
        imagelinethick($image, 250, $i * 100 + 250, 3500 + 250, $i * 100 + 250, $red, 2);
      }

      for ($i=0; $i < 8; $i++) {
        imagelinethick($image, $i * 500 + 250, 250, $i * 500 + 250, $rows * 800 + 250, $red, 4);
      }
      for ($i=0; $i < 2 * $rows + 1; $i++) {
        imagelinethick($image, 250, $i * 400 + 250, 3500 + 250, $i * 400 + 250, $red, 4);
      }

      imagelinethick($image, 250, 150, 250, 250, $black, 4);
      imagelinethick($image, 750, 150, 750, 250, $black, 4);
      imagelinethick($image, 250, 200, 420, 200, $black, 4);
      imagelinethick($image, 580, 200, 750, 200, $black, 4);
      imagefttext($image, 50, 0, 470, 220, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "1s");

      imagelinethick($image, 50, 650, 90, 650, $black, 4);
      imagelinethick($image, 90, 650, 90, 450, $black, 4);
      imagelinethick($image, 90, 450, 170, 450, $black, 4);
      imagelinethick($image, 170, 450, 170, 650, $black, 4);
      imagelinethick($image, 170, 650, 210, 650, $black, 4);
      imagefttext($image, 50, 0, 70, 725, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "1mv");


      // 心电波形
      for ($i=0; $i < $rows; $i++) {
        // 每一行纵坐标加800
        $row = $dot[$i];
        for ($j=0; $j < (count($row) - 1); $j++) {
          $y1 = $row[$j] + 800*$i;
          $y2 = $row[$j+1] + 800*$i;
          imagelinethick($image, $j + 250, $y1, $j+251, $y2, $black, 4);
        }
      }

      header("Content-type: image/png");

      imagepng($image);
      imagedestroy($image);
    }

    // plot sleep img
    function SleepPlot($hexs)
    {
      $hex = str_split($hexs, 32);


      $dot = array_chunk($hex, 720);
      $rows = count($dot);

      function hex2sec($str)
      {
        // e007-07-1e 01:03:02 60 31 0000000008001f
        $time = hexdec(substr($str, 2, 2).substr($str, 0, 2)) . "-" . hexdec(substr($str, 4, 2)) . "-" . hexdec(substr($str, 6, 2)) . " " . hexdec(substr($str, 8, 2)) . ":" . hexdec(substr($str, 10, 2)) . ":". hexdec(substr($str, 12, 2));

        $second = strtotime($time);

        return $second;
      }

      // Plot
      $width = 1640;
      $height = 540 * $rows + 200;

      $image = imagecreatetruecolor($width, $height);
      $white = imagecolorallocate($image, 255, 255, 255);
      $yellow = imagecolorallocate($image,255,255,0);
      $red = imagecolorallocate($image,255,0,0);
      // $red2    = imagecolorallocate($image,255,0,0);
      $black = imagecolorallocate($image,0,0,0);
      $grey = imagecolorallocate($image,200,200,200);

      imagefill($image, 0, 0, $white);

      imagefttext($image, 20, 0, 50, 50, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "SpO2");
      imagefttext($image, 20, 0, 1450, 50, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "Heart Rate");

      for ($k=0; $k < $rows; $k++) {
        // 每一行纵坐标加500Hz
        $row = $dot[$k];

        for ($i=0; $i < count($row); $i++) {
          $str = $row[$i];

          $second = hex2sec($str);
          $start = hex2sec($row[0]);

          $hr[$i] = hexdec(substr($str, 16, 2));
          $oxy[$i] = hexdec(substr($str, 14, 2));
          $hPx[$i] = ($second - $start) / 5;

          imageline($image, 100, $k * 540 + 100, 1540, $k * 540 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "100%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "170");
          imageline($image, 100, $k * 540 + 100 + 500/7, 1540, $k * 540 + 500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "95%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "150");
          imageline($image, 100, $k * 540 + 100 + 2*500/7, 1540, $k * 540 + 2*500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 2*500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "90%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 2*500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "130");
          imageline($image, 100, $k * 540 + 100 + 3*500/7, 1540, $k * 540 + 3*500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 3*500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "85%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 3*500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "110");
          imageline($image, 100, $k * 540 + 100 + 4*500/7, 1540, $k * 540 + 4*500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 4*500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "80%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 4*500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "90");
          imageline($image, 100, $k * 540 + 100 + 5*500/7, 1540, $k * 540 + 5*500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 5*500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "75%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 5*500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "70");
          imageline($image, 100, $k * 540 + 100 + 6*500/7, 1540, $k * 540 + 6*500/7 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 6*500/7 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "70%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 6*500/7, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "50");
          imageline($image, 100, $k * 540 + 100 + 500, 1540, $k * 540 + 500 + 100, $grey);
          imagefttext($image, 15, 0, 50, $k * 540 + 500 + 100, $black, '/var/www/laravel/app/Http/Controllers/consola.ttf', "65%");
          imagefttext($image, 15, 0, 1580, $k * 540 + 100 + 500, $red, '/var/www/laravel/app/Http/Controllers/consola.ttf', "30");
        }

        // 一个值无效则跳到下一个值，有效则判断下一个点。下一个点有效则画线，无效则画一个点

        for ($j=0; $j < count($hPx) -1; $j++) {
          if ($hr[$j] == 255) {
            continue;
          } else {
            if ($hr[$j+1] == 255) {
              $xx1 = $hPx[$j] + 100;
              $yy1 = 600 - ($hr[$j] - 30)*25/7 + $k * 540;

              imagesetpixel($image, $xx1, $yy1, $red);
            } else {
              $xx1 = $hPx[$j] + 100;
              $yy1 = 600 - ($hr[$j] - 30)*25/7 + $k * 540;

              $xx2 = $hPx[$j+1] + 100;
              $yy3 = 600 - ($hr[$j+1] - 30)*25/7 + $k * 540;

              imagelinethick($image, $xx1, $yy1, $xx2, $yy3, $red, 2);
            }
          }
        }

        for ($j=0; $j < count($hPx) -1; $j++) {
          if ($oxy[$j] == 255) {
            continue;
          } else {
            if ($oxy[$j+1] == 255) {
              $xx1 = $hPx[$j] + 100;
              $yy2 = 600 - 100 / 7 * ($oxy[$j] - 65) + $k * 540;

              imagesetpixel($image, $xx1, $yy2, $black);
            } else {
              $xx1 = $hPx[$j] + 100;
              $yy2 = 600 - 100 / 7 * ($oxy[$j] - 65) + $k * 540;

              $xx2 = $hPx[$j+1] + 100;
              $yy4 = 600 - 100 / 7 * ($oxy[$j+1] - 65) + $k * 540;

              imagelinethick($image, $xx1, $yy2, $xx2, $yy4, $black, 2);
            }
          }
        }

        $hr = [];
        $oxy = [];
        $hPx = [];
      }


      header("Content-type: image/png");

      imagepng($image);
      imagedestroy($image);
    }


    if (Observation_component::find($id)->code_display == "MDC_ECG_ELEC_POTL_I") {
      EcgPlot($hexs);
    } else {
      SleepPlot($hexs);
    }

  }
}

 ?>
