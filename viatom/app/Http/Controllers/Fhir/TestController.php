<?php
namespace App\Http\Controllers\Fhir;

// use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Jobs\SendApiNotice;
use App\Http\Controllers\Controller;
use App\ApiNotice;
use App\User;

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
      ->header('Content-Type', 'application/json');
  }

        function api() {
                // $client = new \GuzzleHttp\Client();
                // $res = $client->request('GET', 'https://api.viatomtech.com.cn/time.php');

                // $response = $res->getBody();
                $api_notice = new ApiNotice;

                $api_notice->user_id = 605;
                $api_notice->company = 'RAHAH';
                $api_notice->type = 'patient';
                $api_notice->patient_id = 1156;
                $api_notice->observation_id = NULL;
                $api_notice->resource_type = NULL;

                 $api_notice->save();

                 $user = User::where('id', 1)->first();

                $this->dispatch(new SendApiNotice($user));


                // return response($response)
                //       ->header('Content-Type', 'application/json+fhir');
                $response['status'] = 'ok';
                $response['api_notice_id'] = $api_notice->id;
                return response($response)
                      ->header('Content-Type', 'application/json+fhir');
        }
}
