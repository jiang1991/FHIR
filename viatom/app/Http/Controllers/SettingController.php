<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class SettingController extends Controller {

  public function __construct()
    {
      if (request()->cookie('locale') == 'zh') {
            App::setLocale('zh');
        }
        $this->middleware('auth');
    }

  public function index() {
    $user = Auth::user();

    return view('setting', [
    'user' => $user,
    ]);
  }

  
}