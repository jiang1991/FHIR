<?php
namespace App\Http\Controllers\Fhir;

use DB;
use Illuminate\Routing\Controller;
use Auth;

class searchController extends Controller
{
  function search()
  {
    /*查询 user id*/
    $user = Auth::user();
    $userId = $user->id;

    /*查询分享给这个 user 的 patient Id */
    // TODO: 目前只查询分享给这个用户的第一个人
    // $patientIds = DB::table('ShareTo')->WHERE('userId', "$userId")->first()->patientsId;

    $records = DB::table('record')->WHERE('userId', "$userId")
                                  // ->orWHERE('patientsId')
                                  ->get();
    // TODO: 判断是否有结果
    $i = 0;
    foreach ($records as $record) {
      $response[$i] = $record;
      $i++;
    };

    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}