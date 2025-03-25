<?php
namespace App\Traits;

use App\Helpers\MyHelper;
use App\Models\Client;
use App\Models\ScheduleDetails;
use App\Models\Turnstile;
use App\Traits\RecordTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

trait ReportFilterTrait{
    use RecordTrait;
    // abstract function model();

 public function filter($data)
  {

         // dd($data);
          $attendance_sheet = $data['attendance_sheet'];
       // dd($attendance_sheet);


$groupedEntries = $attendance_sheet->groupBy(['people_id', function ($oneFromCollection) {
    return Carbon::parse($oneFromCollection->date)->toDateString();
}]);

// dd($data['client_id']);
// dd($groupedEntries);

            $get_client_schedule = $data['client_id'];
            // dd($get_client_schedule);
            $client_scheduls = MyHelper::get_client_schedule();


            $peopleDailyRecord =[];
            foreach ($groupedEntries as $peopleId => $dailyRecords) {
                // dd($dailyRecords);
                // dd($peopleId);

                foreach ($dailyRecords as $date => $records) {

                    // dd($date);   //"2025-03-20"
                    // dd($records);

                    $day = date('d',strtotime($date));
                    // dd($day);//20

                    $records = $records->sortBy('date')->unique('date'); // Ensure records are sorted by time
                     // dd()
                    $entryTime = null;

                    // վերադարձնում է ամսվա այդ օրը շաբաթվա ինչ օր է
                    $dayOfWeek = Carbon::parse(time: $date)->format('l');
                    // dd($date,$dayOfWeek);//Thursday
                    // $clientSchedule = $clientWorkingTimes[$dayOfWeek] ?? null;
                    //   dd($records->first()->schedule_name_id);
                    $peopleDailyRecord = $this->getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day, $entryTime);
                    // dd($people_records);

                    $worker_first_enter = $records->first();
                    // dd($worker_first_enter->schedule_name_id);

                    $schedule_id = $worker_first_enter->schedule_name_id;
                    $clientWorkingTimes = ScheduleDetails::where('schedule_name_id',$schedule_id)
                                                         ->get()
                                                         ->keyBy('week_day');
                                                         ;
                    // dd( $clientWorkingTimes);
                    $clientSchedule = $clientWorkingTimes[$dayOfWeek] ?? null;
                    // dd($clientSchedule);
                    if(isset($clientSchedule)){
                        if($worker_first_enter->direction == "enter"){
                            $get_client_week_working_start_time='';
                            $get_client_week_working_end_time='';

                            if(isset($clientSchedule->day_start_time) && $clientSchedule->day_start_time!=null){
                                $get_client_week_working_start_time = new DateTime($clientSchedule->day_start_time);
                                // dd($get_client_week_working_start_time);


                            }
                            if( isset($clientSchedule->day_start_time) && $clientSchedule->day_end_time!=null){
                                $get_client_week_working_end_time = new DateTime($clientSchedule->day_end_time);

                            }
                            // dd($get_client_week_working_end_time);
                            // dd($worker_first_enter->date); //"2025-03-20 10:05:38"
                            $worker_first_enter_time = explode(' ', string: $worker_first_enter->date)[1];
                            // dd($worker_first_enter_time); //"10:05:38"
                            $worker_first_enter_time = new DateTime($worker_first_enter_time);
                            // աշխատակցի առաջին մուտքի ժամը  փոքր է գործատուի տվյալ օրվա աշխատանքային ավարտի ժամից
                            if($worker_first_enter_time < $get_client_week_working_end_time){
                                // dd($worker_first_enter_time,$get_client_week_working_start_time);
                                // աշխատակիցը ուշացել է, աշխատակցի առաջին մուտքը մեծ է գործատուի շաբաթվա տվյալ օրվա աշխատանքի սկսման  օրվանից
                                if($worker_first_enter_time>$get_client_week_working_start_time){
                                    // dd($get_client_week_working_start_time);

                                    $interval = $worker_first_enter_time->diff($get_client_week_working_start_time);
                                    $peopleDailyRecord[$peopleId][$day]['delay_hour'][]=$interval->format('%H:%I:%S');
                                    $peopleDailyRecord[$peopleId][$day]['delay_display']=true;
                                    $peopleDailyRecord[$peopleId][$day]['coming']=true;
                                    // dd($peopleDailyRecord);


                                }else{
                                    $peopleDailyRecord[$peopleId][$day]['coming']=true;
                                }
                                // ============
                                // dd($records);
                                // dd($clientSchedule->break_start_time,  $clientSchedule->break_end_time);
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
                                // dd($breakfastInterval);
                                $breakfastInterval_find_mac = $records
                                                            ->filter(function ($record) use ($clientSchedule) {
                                                            $recordTime = (new DateTime($record->date))->format('H:i:s');
                                                                return $recordTime >= $clientSchedule->break_start_time && $recordTime <= $clientSchedule->break_end_time;
                                                            })
                                                            ->sortByDesc('date') // Sort by date in descending order
                                                            ->groupBy('direction') // Group records by 'direction'
                                                            ->map(function ($group) {
                                                                return $group->first()->mac; // Take the first (latest) record's date from each group
                                                            });
                                                            $ushacum = false;
                                                            // dd($breakfastInterval);
                                                            if(count($breakfastInterval)>0){
                                                                // dd(888);
                                                                if(count($breakfastInterval)==1 && isset($breakfastInterval["exit"])){

                                                                    $ushacum = true;

                                                                }
                                                                if(count($breakfastInterval)>1 ){



                                                                    // dump( $peopleId, $breakfastInterval,$breakfastInterval_find_mac);
                                                                    $enterTime='';
                                                                    $exitTime = '';
                                                                    if(isset($breakfastInterval_find_mac['unknown'])){
                                                                        $turnstile=Turnstile::where('mac',$breakfastInterval_find_mac['unknown'])->first();

                                                                        if($turnstile){
                                                                            if($turnstile->direction == "exit"){
                                                                                $exitTime = new DateTime($breakfastInterval['unknown']);
                                                                                // dump($exitTime);

                                                                            }
                                                                            else{
                                                                                $enterTime = new DateTime($breakfastInterval['unknown']);
                                                                            }
                                                                        }
                                                                    }else{

                                                                        $enterTime = new DateTime($breakfastInterval['enter']);
                                                                        if(isset($breakfastInterval['enter'])){
                                                                                if(isset($breakfastInterval['exit'])){
                                                                                    $exitTime = new DateTime($breakfastInterval['exit']);

                                                                                }
                                                                        }

                                                                        //   dump( $peopleId, $breakfastInterval,$breakfastInterval_find_mac);


                                                                    }
                                                                    if(isset($enterTime) && isset($exitTime)){
                                                                        // dump($peopleId, $enterTime, $exitTime);
                                                                        if ($exitTime > $enterTime) {
                                                                                    $ushacum = true;
                                                                                }
                                                                    }


                                                                }



                                                            }else{
                                                                // dd(777);


                                                                $firstActionAfterBreakfast = $records
                                                                                ->filter(function ($record) use ($peopleId, $clientSchedule,$day) {
                                                                                    // Parse the date using Carbon and format it to 'H:i:s' (hours:minutes:seconds)
                                                                                    $recordTime = Carbon::parse($record->date)->format('H:i:s');
                                                                                    // dump($day, $peopleId, $recordTime, $clientSchedule->break_end_time);
                                                                                    // Check if the direction is 'enter', the time is after $clientSchedule->break_end_time, and people_id is $peopleId
                                                                                    return $record->direction === 'enter' && $recordTime >= $clientSchedule->break_end_time && $record->people_id == $peopleId;
                                                                                })
                                                                                ->sortBy('date') // Sort by date in ascending order
                                                                                ->first();
                                                                                // dump( $peopleId,$firstActionAfterBreakfast);


                                                                    if( isset($firstActionAfterBreakfast->direction) && $firstActionAfterBreakfast->direction=="enter"){
                                                                        $ushacum=true;
                                                                        // dump($peopleId,"after",$day, $firstActionAfterBreakfast);
                                                                    }
                                                                    // dd($firstActionAfterBreakfast);



                                                            }
                                                            if($ushacum == true){
                                                                // dd($ushacum);
                                                                // dd($peopleId, $date,$day, $clientSchedule, $peopleDailyRecord);


                                                                $peopleDailyRecord=$this->ushacum_arm($peopleId, $date,$day, $clientSchedule, $peopleDailyRecord);
                                                                //   dd($peopleDailyRecord);
                                                            }



                            }



                        }else{

                            $peopleDailyRecord[$peopleId][$day]['anomalia']=true;

                        }

                    }






                }
            }
            // dd($peopleDailyRecord);
            if(isset($peopleDailyRecord)){

                $client = Client::where('id', $data['client_id'])->first();
                // dd($peopleDailyRecord);
                $total_monthly_working_hours = $this->calculate_arm($peopleDailyRecord,$client);
                // dd( $total_monthly_working_hours);

                $routeName = Route::currentRouteName();
                // dd( $routeName);
                if($routeName=="export-xlsx-armobil"){
                    $total_monthly_working_hours['mounth']=$month;

                }
                // dd($total_monthly_working_hours);

                return  $peopleDailyRecord = $total_monthly_working_hours ?? null;

            }else{
                return false;
            }






  }

    public function ushacum_arm($peopleId, $date,$day, $clientSchedule, $peopleDailyRecord){



            $firstAfter1400 = DB::table('attendance_sheets')
                ->where('direction', 'enter')
                ->where('people_id', $peopleId)
                ->whereDate('date', date('Y-m-d', strtotime($date)))
                ->whereTime('date', '>', $clientSchedule->break_end_time) // Время после 14:00
                ->orderBy('date', 'asc') // Сортируем по времени
                ->first();
                    // dump($firstAfter1400);
                    // dd($firstAfter1400);

                if($firstAfter1400){


                    $firstAfter1400_datePart = explode(' ', $firstAfter1400->date)[1];
                    // dd($firstAfter1400_datePart); //"14:10:38"


                                $firstAfter1400_time1 = new DateTime($firstAfter1400_datePart);

                                $firstAfter1400_time2 = new DateTime($clientSchedule->break_end_time);

                                $firstAfter1400_interval = $firstAfter1400_time1 ->diff($firstAfter1400_time2);

                                // dump($firstAfter1400_interval->format('%H h %I m'));
                                // dd($firstAfter1400_interval);

                    if($firstAfter1400_interval->format('%H h %I m')!=="00 h 00 m"){
                        // եթե աշխատողի մուտքը ընդմիջումից հետո  մտել է 14։10։38
                        // dd($firstAfter1400_interval->format('%H:%I:%S')); //"00:10:38"

                        $peopleDailyRecord[$peopleId][$day]['delay_hour'][]= $firstAfter1400_interval->format('%H:%I:%S');
                        $peopleDailyRecord[$peopleId][$day]['delay_display']=true;
                        // dump($peopleDailyRecord);
                        // dd($peopleDailyRecord);

                    }

                }

// dd($peopleDailyRecord);

                return  $peopleDailyRecord;
    }

    public function calculate_arm($peopleDailyRecord,$client){
      // dd($peopleDailyRecord);
      $fullTotalSeconds = 0;
        foreach ($peopleDailyRecord as $personId => $records) {
            // dd($records);
            $totalSeconds = 0;
            $delaytotalSeconds = 0;
            // dd($records);

            // Iterate through each person's records
             foreach ($records as $key=>&$data) {
                // dd($key,$data);
                if (isset($data['working_times'])) {
                        $totalSeconds = 0;

                    foreach ($data['working_times'] as $time) {
                        // dump($time);
                         // Convert each time string (HH:MM:SS) to seconds
                         list($hours, $minutes, $seconds) = explode(':', $time);
                        $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
                    }
                     // dd( $peopleDailyRecord[$key]);
                     $data['daily_working_time'] = $totalSeconds;
                     // $peopleDailyRecord[$records][$key]['daily_working_time'] = $totalSeconds;
                     $fullTotalSeconds += $totalSeconds;
                }

                if (isset($data['delay_hour'])) {
                    foreach ($data['delay_hour'] as $delay) {
                        // Convert each time string (HH:MM:SS) to seconds
                        list($hours, $minutes, $seconds) = explode(':', $delay);
                        $delaytotalSeconds += $hours * 3600 + $minutes * 60 + $seconds;
                    }
                }

            }
            // dd($fullTotalSeconds);
            $fullTotalHours = floor($fullTotalSeconds / 3600);
            $fullTotalSeconds %= 3600;
            $fullTotalMinutes = floor($fullTotalSeconds / 60);
            $fullTotalSeconds %= 60;


            // Convert total seconds back to hours, minutes, and seconds
            $totalHours = floor($totalSeconds / 3600);
            $totalSeconds %= 3600;
            $totalMinutes = floor($totalSeconds / 60);
            $totalSeconds %= 60;

            $delaytotalHours = floor($delaytotalSeconds / 3600);
            $delaytotalSeconds %= 3600;
            $delaytotalMinutes = floor($delaytotalSeconds / 60);
            $delaytotalSeconds %= 60;

            $peopleDailyRecord[$personId]['totalMonthDayCount'] =count($records);
            // Format the result into HH:MM:SS
            // dump($totalHours, $totalMinutes, $totalSeconds);
            // dd($totalHours);
            $peopleDailyRecord[$personId]['totalWorkingTimePerPerson'] = sprintf( '%d ժ, %d ր, %d վ', $fullTotalHours, $fullTotalMinutes, $fullTotalSeconds);

            $peopleDailyRecord[$personId]['totaldelayPerPerson'] = sprintf('%d ժ, %d ր, %d վ', $delaytotalHours, $delaytotalMinutes, $delaytotalSeconds);
            // dd($peopleDailyRecord);
            // dd($client->working_time,$totalHours);
            $clientWorkingHours = (float) $client->working_time; // Convert string to float
            $personWorkingHours = (float) $totalHours;
            if($clientWorkingHours>$personWorkingHours){
                $peopleDailyRecord[$personId]['personWorkingTimeLessThenClientWorkingTime'] =true;

            }
        }
        // dd($peopleDailyRecord);
        return  $peopleDailyRecord;


    }

}
