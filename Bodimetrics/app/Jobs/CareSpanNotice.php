<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CareSpanNotice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * This is used for CareSpan Notification
     *
     * @return void
     */
    /*public function __construct()
    {
        //
    }*/

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($notice)
    {
        $client = new \GuzzleHttp\Client();
        $client->request('POST', 'https://cloud.viatomtech.com/json.php', [
          'form_params' => $notice,
          'verify' => false,
          ]);

        return true;
    }
}
