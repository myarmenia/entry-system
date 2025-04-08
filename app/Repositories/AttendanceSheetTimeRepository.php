<?php
namespace App\Repositories;

use App\Interfaces\AttendanceSheetTimeInterface;
use App\Models\AttendanceSheet;
use App\Models\EntryCode;
use App\Models\PersonPermission;
use App\Models\ScheduleDepartmentPerson;
use App\Models\ScheduleDetails;
use Carbon\Carbon;
use Dotenv\Parser\Entry;

class AttendanceSheetTimeRepository implements AttendanceSheetTimeInterface
{
    public function store($tb_name, $person_id, $client_id, $direction, $date, $day, $enterExitTime, $time)
    {
        // dd($tb_name,$person_id,$client_id,$direction,$date,$day,$time,$existingTime);

        $db_time='';
        $compeare_direction ='';

        $fullDate =  $date."-".$day;
        // dd($fullDate);

        $fullTime = $time.":00"; //get time from request
        // dd($fullTime);

        // dd($formatted_time);

        $dayOfWeek = Carbon::parse(time: $fullDate)->format('l');
        $schedule_name_id = ScheduleDepartmentPerson::where(['client_id'=>$client_id,'person_id'=>$person_id])->value('schedule_name_id');
        $schedule_details = ScheduleDetails::where(['schedule_name_id'=>$schedule_name_id,'week_day'=>$dayOfWeek])->first();
        $clientDayEndTime = Carbon::parse($schedule_details->day_end_time); // client working end time
        $clientDayStartTime = Carbon::parse($schedule_details->day_start_time); // client working start time
        $workerEnterExitTime  = Carbon::parse($fullTime);      // աշխատակցի մուտքի կամ ելքի ժամանակն է
        $beforEnterExitTime = Carbon::parse($enterExitTime);   // աշխատակցի մուտքի կամ ելքի  բազայի ժամանակն է
// dd("day_end_time",$clientDayEndTime , "day_start_time",$clientDayStartTime, $workerEnterExitTime);
// dump($workerEnterExitTime);
        if ($workerEnterExitTime->between($clientDayStartTime, $clientDayEndTime)) {
            // dd($workerEnterExitTime, $beforEnterExitTime);
            if($workerEnterExitTime->lessThan($beforEnterExitTime)){

                return "Մուտքագրված ժամ";
            }


            // return response()->json(['message' => 'Worker entry time is OK'], 200);
        } else {
            return "Մուտքագրված ժամանակը չի համապատասխանում գործատուի աշխատանքային ժամանակացույցին";
        }



        if($direction=="exit"){
            $db_time = $schedule_details->day_end_time;
            // dd($db_time);
            if($clientDayEndTime<$clientDayStartTime){
                // dd("db_time",$db_time,"day_start_time",$day_start_time);
                $fullDate = Carbon::parse($fullDate);
                // dd($fullDate);
                $fullDate->addDay();
                // dd($fullDate);
                $fullDate = $fullDate->toDateString();
                // $fullDate = $fullDate->format('Y-m-d');
                // dd($fullDate);

            }

        }else{
            $db_time = $schedule_details->day_start_time;


        }

        $db_time = strtotime($db_time);  //client working time
        $time_tostr = strtotime($fullTime);
        dd($fullTime);
        dd($db_time,$time_tostr);


            if ($db_time !== $time_tostr) {
                $formatted_time = date("H:i:s", $db_time);

                return  "Մուտքագրվող ժամանակը պետք է լինի ". $formatted_time;
            }


        $entry_code_id = PersonPermission::where('person_id',$person_id)->value('entry_code_id');
        // dd($entry_code);
        $entry_code_token = EntryCode::where('id',$entry_code_id)->value('token');

        $date = $fullDate." ".$fullTime;
        // dd($date);

        $store_data = [
            "people_id" => $person_id,
            "entry_code" => $entry_code_token,
            "date" => $date,
            "direction" => $direction
        ];
        $attendance_sheet =  AttendanceSheet::create($store_data);
        // dd($data);
        if($attendance_sheet){
            return "Գործողությունը հաստատված է:";
        }
    }
}
