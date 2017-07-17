<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\User;

class SettingController extends Controller {

  public function __construct()
    {
        $this->middleware('auth');
    }

  public function index() {
    $user = Auth::user();

    return view('setting', [
    'user' => $user,
    ]);
  }

  
}