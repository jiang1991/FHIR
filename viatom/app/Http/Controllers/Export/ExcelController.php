<?php
namespace App\Http\Controllers\export;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Routing\Controller;
use App\Patient;
use App\Observation;
use App\Observation_component;
use App\Repositories\ObservationRepository;

use Excel;


/**
* export excel
*/
class ExcelController extends Controller
{
	protected $observation;
	protected $patient;

	function __construct(ObservationRepository $observation)
	{
		$this->observation = $observation;
	}

	function export($id) {
		// $patient = $this->observation->observation($id)->patient;
		$observation = $this->observation->observation($id)->first();
		// 睡眠数据
		$observation_component = Observation_component::where('observation_id', $id)
			->where('code_display', 'SLEEP_III')
			->first();
		$waveString = $observation_component->valueString;

		// if ($observation->resourceId ==  'sleep') {
		// 	// 睡眠数据
		// 	$observation_component = Observation_component::where('observation_id', $id)
		// 		->where('code_display', 'SLEEP_III')
		// 		->first();
		// 	$waveString = $observation_component->valueString;
		// } elseif ($observation->resourceId ==  'monitor') {
		// 	//计步数据
		// 	$observation_component= Observation_component::where('observation_id', $id)
		// 		->where('code_display', 'Steps-II')
		// 		->first();
		// 	$waveString = $observation_component->valueString;
		// }

		// $data = substr($waveString, 40);
		$ponits = str_split($waveString, 10);

		$report = [];
		$report[] = ['index', 'HR', 'SpO2', 'Motion', 'vibration'];

		for ($i=0; $i < count($ponits); $i++) { 
			$ponit = $ponits[$i];

			$hr = hexdec(substr($ponit, 4, 2) . substr($ponit, 2, 2));
			$hr = $hr == 65535 ? -1 : $hr;
			$oxy = hexdec(substr($ponit, 0, 2));
			$oxy = $oxy == 255 ? -1 : $oxy;
			$mo = hexdec(substr($ponit, 6, 2));
			$vi = hexdec(substr($ponit, 8, 2)) != 0;

			// $hr = substr($ponit, 4, 2) . substr($ponit, 2, 2);
			// $oxy = substr($ponit, 0, 2);
			// $mo = substr($ponit, 6, 2);
			// $vi = substr($ponit, 8, 2);

			$report[] = [$i, $hr, $oxy, $mo, $vi];
		}
		
		
		return Excel::create('Report_'.$id, function($excel) use ($report) {

			$excel->setTitle('report');
			// $excel->setDescription($id);

			$excel->sheet('sheet1', function($sheet) use ($report) {
				$sheet->fromArray($report, null, "A1", true, false);
			});
		})->download('xlsx');




		// return Excel::create('report', function($excel) use ($report) {
		// 	$excel->sheet('report', function($sheet) use ($report) {
		// 		$sheet->fromArray($report);
		// 	});
		// })->download('xlsx');
	}
}

