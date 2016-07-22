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


    $dots = dec2px($hexs);

    // return $dots;

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
}

 ?>
