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

                foreach ($groupedEntries as $peopleId => $dailyRecords) {
                    $totalWorkingTime = 0; // Секунды
                    $daysWorked = 0; // Количество отработанных дней
                    $totalDelayTime = 0; // Время задержки (в секундах)
                    $delay_arr = [];
                    // dd($dailyRecords);
                    foreach ($dailyRecords as $date => $records) {
                        // dd($date);

                        // dd($records);
                        $records = $records->sortBy('date'); // Ensure records are sorted by time
                        // dd($records);
                        $entryTime = null;
                        $dailyWorkingTime = 0; // Секунды

                        foreach ($records as $record) {


                            if ($record->direction === 'enter') {
                                $entryTime  = Carbon::parse($record->date);


                            } elseif ($record->direction === 'exit' && $entryTime) {

                                $exitTime = Carbon::parse($record->date);

                                    $entry = explode(' ', $entryTime->toTimeString())[0];
                                    $entryT = Carbon::createFromFormat('H:i:s', $entry);


                                    $exit = explode(' ', $exitTime->toTimeString())[0];
                                    $exitT = Carbon::createFromFormat('H:i:s', $exit);
                                    // dd($entryT, $exitT );
                                    // $entryT = Carbon::createFromFormat('H:i:s', '15:11:44');
                                    // $exitT = Carbon::createFromFormat('H:i:s', '15:20:41');


                                    // Если вход и выход в один день, добавляем разницу
                                    if ($exitT->greaterThan($entryT)) {
                                        $interval = $exitT->diff($entryT);

                                        $delay_arr[]=$interval->format('%H:%I:%S');


                                        // dd($dailyWorkingTime);
                                    }

                                // Сбрасываем время входа после расчета
                                $entryTime = null;


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

                    // // Convert working time to hours and minutes
                    // $totalWorkingTimeInSeconds = $totalWorkingTime;
                    // $hours = floor($totalWorkingTimeInSeconds / 3600);
                    // $minutes = floor(($totalWorkingTimeInSeconds % 3600) / 60);

                    // $totalWorkingTimePerPerson[$peopleId] = "{$hours}h {$minutes}m";
                    // $daysWorkedPerPerson[$peopleId] = $daysWorked; // Store the number of days worked
                    // $delayTimesPerPerson[$peopleId] = gmdate("H:i:s", $totalDelayTime); // Format delay time as H:i:s
                    dd($delay_arr);
                }

                // Debugging output (can be removed after testing)
                // dd($totalWorkingTimePerPerson, $daysWorkedPerPerson, $delayTimesPerPerson);

// dd($groupedEntries);
                    return  $groupedEntries;

        }


    }
}
