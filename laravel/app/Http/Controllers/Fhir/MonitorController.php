<?php
namespace App\Http\Controllers\Fhir;

use App\Real_monitor;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 
 */
class MonitorController extends Controller
{
	
	function upload(Request $request) {
		$date = $request->DateM;
		$time = $request->TimeM;
		$seq_no = $request->SeqNo;
		$begin = $request->Begin;
		$end = $request->End;
		// checkme serial no
		$serial_no = $request->SerialNo;
		$location = "";
		if (isset($request['Location'])) {
			$location = $request->Location;
		}
		// $location = $request->Location;	
		$user_id = $request->UserId;
		$password = $request->Password;
		$prefix = $request->Prefix;
		$suffix = $request->Suffix;

		if ($query = Real_monitor::where('date_m', $date)->where('time_m', $time)->where('seq_no', $seq_no)->where('user_id', $user_id)->first()) {
			$response["status"] = "ok";
			$response["isNew"] = false;
			$response["seq_no"] = $seq_no;
			$response["user"] = $user_id;

			return response($response)
        		->header('Content-Type', 'application/json');
		}

		$request->file('CheckMonitorRaw')->move('/var/www/laravel/public/APP/monitor_data', $time . $seq_no);
		$check_monitor_raw = 'https://api.viatomtech.com.cn/APP/monitor_data/' . $time . $seq_no;

		$monitor = new Real_monitor;
		$monitor->date_m = $date;
		$monitor->time_m = $time;
		$monitor->seq_no = $seq_no;
		$monitor->begin = $begin;
		$monitor->end = $end;
		$monitor->serial_no = $serial_no;
		$monitor->location = $location;
		$monitor->user_id = $user_id;
		$monitor->password = $password;
		$monitor->prefix = $prefix;
		$monitor->suffix = $suffix;

		$monitor->check_monitor_raw = $check_monitor_raw;

		$monitor->save();

		$response["status"] = "ok";
		$response["isNew"] = true;
		$response["seq_no"] = $seq_no;
		$response["user"] = $user_id;
		$response["file_path"] = $check_monitor_raw;

		return response($response)
        ->header('Content-Type', 'application/json');
	}

	function query() {
		$monitors = Real_monitor::all();

		return view('monitor', [
			'monitors' => $monitors,
		]);
	}
}