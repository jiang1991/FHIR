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
        $dots[] = 400 - $dot[$i] * 0.51238;
        $dots[] = 400 - ($dot[$i] + $dot[$i+1])/2 * 0.51238;
      }
      $dots[] = 400 - $dot[count($dot)-1] * 0.51238;

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

    $width = 3500;
    $height = 800 * $rows;

    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocatealpha($image, 255, 255, 255, 100);
    $yellow = imagecolorallocatealpha($image,255,255,0,100);
    $red    = imagecolorallocatealpha($image,255,0,0,100);
    $red2    = imagecolorallocatealpha($image,255,0,0,50);
    $black   = imagecolorallocatealpha($image,0,0,0,100);

    imagefill($image, 0, 0, $white);

    /**
    *背景框
    */
    for ($i=0; $i < 175; $i++) {
      imageline($image, $i * 20, 0, $i * 20, $rows * 800, $red2);
    }
    for ($i=0; $i < 40 * $rows; $i++) {
      imageline($image, 0, $i * 20, 3500, $i * 20, $red2);
    }

    for ($i=0; $i < 35; $i++) {
      imagelinethick($image, $i * 100, 0, $i * 100, $rows * 800, $red, 2);
    }
    for ($i=0; $i < 8 * $rows; $i++) {
      imagelinethick($image, 0, $i * 100, 3500, $i * 100, $red, 2);
    }

    for ($i=0; $i < 8; $i++) {
      imagelinethick($image, $i * 500, 0, $i * 500, $rows * 800, $red, 4);
    }
    for ($i=0; $i < 2 * $rows + 1; $i++) {
      imagelinethick($image, 0, $i * 400, 3500, $i * 400, $red, 4);
    }





    for ($i=0; $i < $rows; $i++) {
      // 每一行纵坐标加800
      $row = $dot[$i];
      for ($j=0; $j < (count($row) - 1); $j++) {
        $y1 = $row[$j] + 800*$i;
        $y2 = $row[$j+1] + 800*$i;
        imagelinethick($image, $j, $y1, $j+1, $y2, $black, 4);
      }
    }

    header("Content-type: image/png");

    imagepng($image);
    imagedestroy($image);
  }
}

 ?>
