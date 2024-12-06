<?php
namespace App\Traits;

use App\Models\AttendanceSheet;
use App\Models\Client;
use App\Models\ClientWorkingDayTime;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ReportTrait{


    public function report($request){

        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
        $client_working_day_times = ClientWorkingDayTime::where('client_id',$client->id)->select('week_day','day_start_time','day_end_time','break_start_time','break_end_time')->get();
        // $people = $client->people->pluck(['name', 'surname'], 'id');
        $people = $client->people->pluck('id');
        // dd($people);

        if($request->mounth!=null){



            [$year, $month] = explode('-', $request->mounth);

            $monthDate = Carbon::createFromDate($year, $month, 1);

            $startOfMonth =  $monthDate->startOfMonth()->toDateTimeString();
            $endOfMonth =  $monthDate->endOfMonth()->toDateTimeString();


            $attendance_sheet = AttendanceSheet::whereBetween('date', [$startOfMonth, $endOfMonth])
                                ->orderBy('people_id')
                                ->orderBy('date')
                                ->get();

                $groupedEntries = $attendance_sheet->groupBy(['people_id', function ($oneFromCollection) {
                    return Carbon::parse($oneFromCollection->date)->toDateString();
                }]);
                // dd($groupedEntries);


                $clientWorkingTimes = DB::table('client_working_day_times')
                                    ->where('client_id', $client->id)
                                    ->get()
                                    ->keyBy('week_day');

                        // dd($clientWorkingTimes);


                $totalWorkingTimePerPerson = [];
                $daysWorkedPerPerson = [];
                $delayTimesPerPerson = [];
                $peopleDailyRecord=[];

                foreach ($groupedEntries as $peopleId => $dailyRecords) {
                    $totalWorkingTime = 0; // Секунды
                    $daysWorked = 0; // Количество отработанных дней
                    $totalDelayTime = 0; // Время задержки (в секундах)
                    $delay_arr = [];
                    $daily_anomalia=[];

                    // dd($dailyRecords);
                    foreach ($dailyRecords as $date => $records) {
                        // dd($date);



                        $records = $records->sortBy('date'); // Ensure records are sorted by time
                        // dd($records);
                        $entryTime = null;
                        $dailyWorkingTime = 0; // Секунды
                        $dayOfWeek = Carbon::parse($date)->format('l');
                        $clientSchedule = $clientWorkingTimes[$dayOfWeek] ?? null;


                        // foreach ($records as $record) {


                        //     if ($record->direction === 'enter') {
                        //         // dd('enter');
                        //         $entryTime  = Carbon::parse($record->date);


                        //     } elseif ($record->direction === 'exit' && $entryTime) {
                        //         // dd('enter and exit');

                        //         $exitTime = Carbon::parse($record->date);

                        //             $entry = explode(' ', $entryTime->toTimeString())[0];
                        //             $entryT = Carbon::createFromFormat('H:i:s', $entry);


                        //             $exit = explode(' ', $exitTime->toTimeString())[0];
                        //             $exitT = Carbon::createFromFormat('H:i:s', $exit);
                        //             // dd($entryT, $exitT );
                        //             // $entryT = Carbon::createFromFormat('H:i:s', '15:11:44');
                        //             // $exitT = Carbon::createFromFormat('H:i:s', '15:20:41');


                        //             // Если вход и выход в один день, добавляем разницу
                        //             if ($exitT->greaterThan($entryT)) {
                        //                 $interval = $exitT->diff($entryT);

                        //                 $peopleDailyRecord[$peopleId][$date]['working_times'] = $interval->format('%H:%I:%S');


                        //                 // dd($dailyWorkingTime);
                        //             }

                        //         // Сбрасываем время входа после расчета
                        //         $entryTime = null;


                        //     }else if($record->direction === 'exit'){

                        //         $daily_anomalia[$date] = false;

                        //     }
                        // }
                        // dd($records);
                        $worker_first_enter=$records->where('direction', 'enter')->first();
                        // dd($worker_first_enter);
                        if($worker_first_enter){



                                // dd($clientSchedule);
                                $get_client_week_working_start_time =new DateTime($clientSchedule->day_start_time);
                                $get_client_week_working_end_time =new DateTime($clientSchedule->day_end_time);
                                // dd($get_client_week_working_end_time);
                                $worker_first_enter_time = explode(' ', $worker_first_enter->date)[1];
                                // dd($worker_first_enter_time);

                                $worker_first_enter_time = new DateTime($worker_first_enter_time);
                                // dd($get_client_week_working_end_time, $worker_first_enter_time);
                                if($worker_first_enter_time<$get_client_week_working_end_time){

                                    if($worker_first_enter_time>$get_client_week_working_start_time){

                                        $interval = $worker_first_enter_time->diff($get_client_week_working_start_time);

                                        $peopleDailyRecord[$peopleId][$date]['delay_hour']=$interval->format('%h hours, %i minutes, %s seconds');
                                        $peopleDailyRecord[$peopleId][$date]['delay_display']=true;

                                    }

                                }else{
                                    $peopleDailyRecord[$peopleId][$date]['anomalia']=true;

                                }
                        }else{
                            $peopleDailyRecord[$peopleId][$date]['anomalia']=true;
                        }

                    $breakfastInterval = $records
                        ->filter(function ($record) use ($clientSchedule) {
                            $recordTime = (new DateTime($record->date))->format('H:i:s');
                            return $recordTime >= $clientSchedule->break_start_time && $recordTime <= $clientSchedule->break_end_time;
                        })
                        ->sortByDesc('date') // Sort by date in descending order
                        ->groupBy('direction') // Group records by 'direction'
                        ->map(function ($group) {
                            return $group->first()->date; // Take the first (latest) record's date from each group
                        });
                        $ushacum=false;
                    dd($breakfastInterval);
                        if(count($breakfastInterval)>0){

                            if(count($breakfastInterval)==1 && isset($breakfastInterval["exit"])){
                                $ushacum=true;


                            }
                            if(count($breakfastInterval)>1 ){

                                $enterTime = new DateTime($breakfastInterval['enter']);
                                    $exitTime = new DateTime($breakfastInterval['exit']);
                                    // dump($enterTime,$exitTime);


                                    if ($exitTime > $enterTime) {
                                        $ushacum=true;
                                        // dump($delay_arr);

                                    }



                            }
                            if($ushacum==true){
                                

                            }



                        }




                        // Check if there's a lunch break to subtract

                        // $dayOfWeek = Carbon::parse($date)->format('l');
                        // $clientSchedule = $clientWorkingTimes[$dayOfWeek] ?? null;

                        // if ($clientSchedule) {
                        //     $breakStart = Carbon::parse("$date {$clientSchedule->break_start_time}");
                        //     $breakEnd = Carbon::parse("$date {$clientSchedule->day_end_time}");

                        //     if ($entryTime && $entryTime->lessThan($breakEnd)) {
                        //         $dailyWorkingTime -= min($breakEnd->diffInSeconds($breakStart), $breakEnd->diffInSeconds($entryTime));
                        //     }
                        // }

                        // Add working time for the day
                        // $totalWorkingTime += $dailyWorkingTime;

                        // // Count the day as worked if there is at least one entry and exit
                        // if ($dailyWorkingTime > 0) {
                        //     $daysWorked++;
                        // }

                        // Calculate delay if entryTime exists
                        // if ($entryTime) {
                        //     $expectedStart = Carbon::parse("$date {$clientSchedule->start_time}");
                        //     if ($entryTime->greaterThan($expectedStart)) {
                        //         $delayTime = $entryTime->diffInSeconds($expectedStart); // Calculate delay in seconds
                        //         $totalDelayTime += $delayTime;
                        //     }
                        // }
                    }


                    dd($peopleDailyRecord);
                }


                // Debugging output (can be removed after testing)
                // dd($totalWorkingTimePerPerson, $daysWorkedPerPerson, $delayTimesPerPerson);

// dd($groupedEntries);
                    return  $groupedEntries;

        }


    }
    public function ushacum(){



            $firstAfter1400 = DB::table('attendance_sheets')
                ->where('direction', 'enter')
                ->where('people_id', $at->people_id)
                ->whereDate('date', date('Y-m-d', strtotime($at->date)))
                ->whereTime('date', '>', $day_time->break_end_time) // Время после 14:00
                ->orderBy('date', 'asc') // Сортируем по времени
                ->first();


                if($firstAfter1400){


                    $firstAfter1400_datePart = explode(' ', $firstAfter1400->date)[1];

                                $firstAfter1400_time1 = new DateTime($firstAfter1400_datePart);

                                $firstAfter1400_time2 = new DateTime($day_time->break_end_time);

                                $firstAfter1400_interval = $firstAfter1400_time1 ->diff($firstAfter1400_time2);

                    if($firstAfter1400_interval->format('%H h %I m')!=="00 h 00 m"){

                        $delay_arr[] = $firstAfter1400_interval->format('%H h %I m');
                        $delay_color = true;



                    }

                    }



    }
}
