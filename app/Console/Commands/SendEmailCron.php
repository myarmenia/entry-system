<?php

namespace App\Console\Commands;

use App\Mail\SendEmailClient;
use App\Models\AttendanceSheet;
use App\Services\ReportFilterService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
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
    protected $reportFilterService;
    public function __construct(ReportFilterService $reportFilterService)
    {
        parent::__construct();
        $this->reportFilterService = $reportFilterService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // now()->format('Y-m')
         $data = AttendanceSheet::all();
        // dd($user);
        Log::info([ $data]);
        // $filteredData = $this->reportFilterService->filterService(['month' =>"2025-03" ]);
        // $data = "444444";
        // Log::info("aaaaa");
        // foreach($filteredData as $peopleId => $item){
        //     Log::info(111);
        // }

        // dd( $filteredData );

        // Mail::send(new SendEmailClient($data));
        // Log::info("aaaaa", $filteredData);
        //
    }
}
