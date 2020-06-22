<?php
namespace App\Http\Controllers\Oxiupload;

use Illuminate\Routing\Controller;
use Auth;
use App\Device;
use App\Oxiupload;

/**
 * 
 */
class DevicewebController extends Controller
{
	
	function __construct()
	{
		$this->middleware('auth');
	}


	public function devices()
	{
		
		$user = Auth::user();
		$user_id = $user->id;

		$devices = Device::where('user_id', $user_id)->get();

		return view('oxiupload/device', [
			'devices' => $devices,
		]);
	}

	public function resources($device_id)
	{
		$this->middleware('auth');
		
		$user = Auth::user();
		$user_id = $user->id;

		$device = Device::find($device_id);

		if (!$device) {
			return redirect('oxiupload/devices');
		}

		if ($device->user_id != $user_id) {
			return redirect('oxiupload/devices');
		}

		$resources = Oxiupload::where('device_id', $device_id)->paginate(30);

		return view('oxiupload/resource', [
			'device' => $device,
			'resources' => $resources,
		], compact(['resources']));
	}
}