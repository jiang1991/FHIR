<?php
namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

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

  /**
  *@param
  *
  *
  */
  function signup(Request $request)
  {
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    // Registration

  }

}


 ?>
