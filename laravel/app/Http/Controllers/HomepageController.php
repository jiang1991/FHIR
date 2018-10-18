<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 
 */
class HomepageController extends Controller
{
	
	public function __construct()
	{
		# code...
	}

	public function index(Request $request) {

		return view('homepage');
	}
}