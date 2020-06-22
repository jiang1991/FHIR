<?php

namespace App\http\Controllers\Console;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Update_version;
use Auth;


/**
 * 
 */
class ConsoleController extends Controller
{
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	* for review
	* 
	*/
	public function update()
	{
		/**
		* ceo2
		* snoreo2
		* o2ring
		* sleepo2
		* wearo2
		* o2vibe
		* airbp
		* er1
		* er2
		*/

		# query versions
		$ceo2Vs = Update_version::where('deviceName', 'ceo2')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$snoreo2Vs = Update_version::where('deviceName', 'snoreo2')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$o2ringVs = Update_version::where('deviceName', 'o2ring')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$sleepo2Vs = Update_version::where('deviceName', 'sleepo2')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$wearo2Vs = Update_version::where('deviceName', 'wearo2')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$sleepuVs = Update_version::where('deviceName', 'sleepu')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$o2vibeVs = Update_version::where('deviceName', 'o2vibe')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$airbpVs = Update_version::where('deviceName', 'airbp')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$er1Vs = Update_version::where('deviceName', 'er1')
									->where("isLive", 1)->orderBy('id', 'desc')->get();
		$er2Vs = Update_version::where('deviceName', 'er2')
									->where("isLive", 1)->orderBy('id', 'desc')->get();



		return view('console', [
			'ceo2Vs' => $ceo2Vs,
			'snoreo2Vs' => $snoreo2Vs,
			'o2ringVs' => $o2ringVs,
			'sleepo2Vs' => $sleepo2Vs,
			'wearo2Vs' => $wearo2Vs,
			'sleepuVs' => $sleepuVs,
			'o2vibeVs' => $o2vibeVs,
			'airbpVs' => $airbpVs,
			'er1Vs' => $er1Vs,
			'er2Vs' => $er2Vs,
		]);

	}
}


?>