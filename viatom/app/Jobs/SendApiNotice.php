<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ApiNotice;
use App\Patient;
use App\User;

class SendApiNotice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

        private $user;
    /**
     * Create a new job instance.
     * @param int id
     *
     * @return void
     */
    public function __construct(User $user_1)
    {
        $user = $user_1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://api.viatomtech.com.cn/time.php');

        // $res->getStatusCode();
        // 200
        // $res->getHeaderLine('content-type');
        // 'application/json; charset=utf8'
        // $res->getBody();
        // '{"id": 1420053, "name": "guzzle", ...}'


        

        if ($res->getStatusCode() == 200) {
              // save to sql
              // if ($api_notice = ApiNotice::where('id', $id)->first()) {
              //       $api_notice->is_synced = 1;
              //       $api_notice->save();
              // };

              $myfile = fopen('/var/www/cloud/done.job.txt', 'a+')  or die ("error to open file");
              fwrite($myfile, date("Y-m-d H:i:s") . "\n");
              fwrite($myfile,  $user->id . "\n");
              
              fclose($myfile);
        }

    }
}
