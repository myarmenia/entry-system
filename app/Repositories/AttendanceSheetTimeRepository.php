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
    public function store($tb_name,$person_id,$client_id,$direction,$date,$day,$time)
    {

        $db_time='';
        $compeare_direction ='';

        $fullDate =  $date."-".$day;
        // dd($fullDate);

        $fullTime = $time.":00";
        // dd($fullTime);

        // dd($formatted_time);

        $dayOfWeek = Carbon::parse(time: $fullDate)->format('l');
        $schedule_name_id = ScheduleDepartmentPerson::where(['client_id'=>$client_id,'person_id'=>$person_id])->value('schedule_name_id');
        $schedule_details = ScheduleDetails::where(['schedule_name_id'=>$schedule_name_id,'week_day'=>$dayOfWeek])->first();

        if($direction=="exit"){
            $db_time = $schedule_details->day_end_time;

        }else{
            $db_time = $schedule_details->day_start_time;
        }
        $db_time = strtotime($db_time);
        $time_tostr = strtotime($fullTime);


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
