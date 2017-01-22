<?php
namespace App\Http\Controllers;

use Auth;
use App\User;
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
      $response["user_id"] = $user->id;
      $response["name"] = $user->name;
      $response["email"] = $user->email;
      return response($response)
        ->header('Content-Type', 'application/json+fhir');
    } else {
      $response["error"] = 'Email or Password invalid!';

      return response($response, '401')
        ->header('Content-Type', 'application/json+fhir');
    }
  }


  function SignUp(Request $request)
  {
    $validator = Validator::make($request->all(),[
      'name' => 'required|max:255',
      'email' => 'required|email|max:255|unique:users',
      'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
      return response($validator->messages(), '200')
        ->header('Content-Type', 'application/json+fhir');
    }

    if ($request['sign'] == "carespan") {
      $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
        'is_carespan' => true,
      ]);
    } else {
      $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
      ]);
    }
    
    $response["status"] = 'ok';
    $response["user_id"] = $user->id;

    return response($response, '200')
      ->header('Content-Type', 'application/json+fhir');
  }

}


 ?>
