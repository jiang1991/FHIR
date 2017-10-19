<?php
namespace App\Http\Controllers\Fhir;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * test
 */
class testController extends Controller
{

  function user() {
    // seed
    $random = rand(0, 10);

    // 1
    $user["id"] = 2;
    $user["name"] = "jiang";
    $user["ico"] = 1;
    $user["gender"] = "male";
    $user["birthday"] = "1991-08-02";
    $user["weight"] = "78";
    $user["height"] = "158";
    if ($random < 5) {
      $users[] = $user;
    }

    // 2
    $user["id"] = 3;
    $user["name"] = "Dufu";
    $user["ico"] = 2;
    $user["gender"] = "female";
    $user["birthday"] = "1999-08-02";
    $user["weight"] = "80";
    $user["height"] = "169";
    $users[] = $user;

    // 3
    $user["id"] = 4;
    $user["name"] = "Libai";
    $user["ico"] = 3;
    $user["gender"] = "male";
    $user["birthday"] = "1999-08-02";
    $user["weight"] = "78";
    $user["height"] = "155";
    if ($random > 9) {
      $users[] = $user;
    }


    // 4
    $user["id"] = 5;
    $user["name"] = "Wang Zhihuan";
    $user["ico"] = 3;
    $user["gender"] = "female";
    $user["birthday"] = "1989-10-02";
    $user["weight"] = "78";
    $user["height"] = "166";
    $users[] = $user;

    // 5
    $user["id"] = 6;
    $user["name"] = "Wang Bo";
    $user["ico"] = 3;
    $user["gender"] = "female";
    $user["birthday"] = "1929-08-12";
    $user["weight"] = "78";
    $user["height"] = "187";
    if ($random > 3) {
      $users[] = $user;
    }

    // 6
    $user["id"] = 7;
    $user["name"] = "Mark";
    $user["ico"] = 3;
    $user["gender"] = "female";
    $user["birthday"] = "1979-08-02";
    $user["weight"] = "78";
    $user["height"] = "179";
    $users[] = $user;


    // 7
    $user["id"] = 8;
    $user["name"] = "Zard";
    $user["ico"] = 3;
    $user["gender"] = "male";
    $user["birthday"] = "1979-08-02";
    $user["weight"] = "78";
    $user["height"] = "179";
    $users[] = $user;

    $response["users"] = $users;
    return response($response)
      ->header('Content-Type', 'application/json+fhir');
  }
}
