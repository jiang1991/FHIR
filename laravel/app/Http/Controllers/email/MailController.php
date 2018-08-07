<?php

namespace App\Http\Controllers\email;

use Illuminate\Http\Request;

use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Jobs\SendEmail;

/**
 *
 */
class MailController extends Controller
{

  function notification(Request $request, $id)
  {
    $user = User::findOrFail($id);

    $job = (new SendEmail($user))->delay(60);

    $this->dispatch($job);

    return 'done';
  }

}
