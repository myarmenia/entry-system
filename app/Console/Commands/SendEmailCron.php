<?php

namespace App\Console\Commands;

use App\Mail\SendEmailClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendEmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = "444444";

        Mail::send(new SendEmailClient($data));
        Log::info("Cron is working fine!");
        //
    }
}
