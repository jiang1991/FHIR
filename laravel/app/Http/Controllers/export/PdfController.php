<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PDF;

use App\Patient;
use App\Observation;
use App\Observation_component;

use App\Repositories\ObservationRepository;

/**
 * export observation pdf
 */
class PdfController extends Controller
{
  protected $observation;
  protected $patient;

  function __construct(ObservationRepository $observation)
  {
    $this->observation = $observation;
  }

  function export($observation_id)
  {
    $patient = $this->observation->observation($observation_id)->patient;
    $observation = $this->observation->observation($observation_id);
    $observation_components = Observation_component::where('observation_id', $observation_id)->get();

    $css_style = '<style type="text/css">
    .text_info {
      padding-right: 40px;
      padding-bottom: 10px;
      float: left;
    }
    .text_record {
      width: 50%;
      float: left;
      padding-bottom: 10px;
    }
    .logo {
      float: right;
    }
    .report {
      font-size: 32px;
      font-weight: bold;
      float: left;
    }
    .content_table {
      padding-left: 60px;
      padding-right: 60px;
      width: 2000px;
    }
    .info_table {
      width: 1800px;
      margin-top: 20px;
      padding: 20px;
      border: 1px solid #555;
    }
  </style>';
  $html_body = '<body>
    <table align="center" class="content_table">
      <tr>
        <td>
          <div class="report">
            Daily Check Report
          </div>
          <div class="logo"><img width="150px" src="/var/www/cloud/storage/app/viatom-logo.png"></div>
        </td>
      </tr>
      <tr>
        <td>
          <table class="info_table">
            <tr>
              <td>
                <div class="text_info"><strong>Name :</strong> Jiang</div>
                <div class="text_info"><strong>Medical ID :</strong> 420381199108136270</div>
                <div class="text_info"><strong>SN :</strong> 14071010122</div>
                <div class="text_info"><strong>Gender :</strong> Male</div>
                <div class="text_info"><strong>Birth date :</strong> Nov 04, 1989</div>
                <div class="text_info"><strong>Height :</strong> 179 cm</div>
                <div class="text_info"><strong>Weight :</strong> 130 lb</div>
              </td>
            </tr>
            <tr>
              <td>
                <div class="text_record"><strong>HR :</strong> 70 /min</div>
                <div class="text_record"><strong>R-R :</strong> 0.9 s</div>
                <div class="text_record"><strong>SpO2 :</strong> 90 %</div>
                <div class="text_record"><strong>PR :</strong> 71 /min</div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <table align="center" width="2000px">
      <tr>
        <td>
          <img width="2000px" src="/var/www/cloud/storage/app/2958.png">
        </td>
      </tr>
    </table>
</body>';

    $html = $css_style . $html_body;

    $pdf = PDF::loadHTML($html)->save('/var/www/cloud/storage/export/' .  $observation_id . '.pdf');
    return response()->download('/var/www/cloud/storage/export/' .  $observation_id . '.pdf');
  }
}
