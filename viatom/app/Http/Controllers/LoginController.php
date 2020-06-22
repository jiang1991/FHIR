<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Device;
use App\Oxiupload;
use App\Login;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/**
 *
 */
class LoginController extends Controller
{

  /**
  *@param form-data: email, password
  *
  *@return json: user-info
  */
  function UserLogin(Request $request)
  {
    $email = $request->email;
    $password = $request->password;

    if (Auth::attempt(['email' => $email, 'password' => $password])) {
      $user = Auth::user();

      // save to login counts
      $login = Login::firstOrNew([
        'user_id' => $user->id
      ]);
      $login->count = ($login->count) + 1;
      $login->save();

      $response["user_id"] = $user->id;
      $response["name"] = $user->name;
      $response["email"] = $user->email;
      $response["has_trial"] = $user->has_trial;
      $expire_at = $user->expire_at;
      if ($expire_at != "" && (strtotime($expire_at) > strtotime(date("Y-m-d")))) {
        $response["membership"] = $user->membership;
        $response["expire_at"] = $expire_at;
      } else {

        $response["membership"] = "";
        $response["expire_at"] = "";
      }
      
      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    } else {
      $response["error"] = 'Email or Password invalid!';

      return response($response, '401')
        ->header('Content-Type', 'application/json+fhir');
    }
  }

  /**
  *@param form-data: email, password, company
  *
  *@return json: user-info
  */
  function SignUp(Request $request) {
      $validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);

      if ($validator->fails()) { 
            return response()
                  ->json($validator->messages(), 200)
                  ->header('Content-Type', 'application/json');
      }

      /**
      * company list
      *
      * RAHAH
      *
      */
      $company = '';
      // if ($request['company'] ==  'RAHAH') {
      //       $company = 'RAHAH';
      // }

      $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'company' => $company,
            'password' => bcrypt($request['password']),
      ]);

      $response['status'] = 'ok';
      $response['user_id'] = $user->id;
      $response['name'] = $user->name;
      $response['company'] = $company;

      return response($response, '200')
          ->header('Content-Type', 'application/json');

  }


  /**
   * delete account
   */

   function UserDestory(Request $request) {
      $user = Auth::user();
      
      // delete devices
      $user->device()->forceDelete();
      // delete uploads
      $user->oxiupload()->forceDelete();

      User::destroy($user->id);

      $res['status'] = 'ok';
      return response($res, '200')
        ->header('Content-Type', 'application/json');
   }


   /**
    * delete data
    */
  function DeleteDate(Request $request) {
      $user = Auth::user();
      $user_id = $user->id;

      // delete devices
      $user->device()->forceDelete();
      // delete uploads
      $user->oxiupload()->forceDelete();

      $res['status'] = 'ok';
      return response($res, '200')
        ->header('Content-Type', 'application/json');
  }

  /*
   * login times count.
   * country / languages
   * records 
   */
  function LoginCount(Request $request) {
    $user = Auth::user();
    $user_id = $user->id;

    $loginJson = file_get_contents("php://input");
    $loginData = json_decode($loginJson);

    $login = Login::firstOrNew([
        'user_id' => $user->id
    ]);

    if ($loginData->os == "ios") {
      $login->ios = 1;
    } elseif ($loginData->os == "android") {
      $login->android = 1;
    }
    
    $login->local_country = $loginData->country;
    $login->local_lang = $loginData->language;
    $login->records = $loginData->records;
    $login->save();

    $res['status'] = 'ok';
    return response($res, '200')
      ->header('Content-Type', 'application/json');
  }


}


 ?>
