<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

/**
 * 
 */
class LocalController extends Controller
{
	
	function SwitchZh() {
		// session()->put('locale', 'zh');
		return redirect("/")
            ->cookie('locale', 'zh', 60*24*30);
	}

	function SwitchEn() {
		// session()->put('locale', 'en');
		return redirect("/")
            ->cookie('locale', 'en', 60*24*30);
	}
}