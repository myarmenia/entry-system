<?php
namespace App\Traits;

use App\Models\ScheduleDetails;
use App\Models\Turnstile;
use Carbon\Carbon;

trait RecordTrait
{
    public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day, $entryTime){

        $totalSeconds =0;

        // dd($records);
        foreach ($records as $record) {
            // dd($record);
            // dd($record->schedule_name_id);





            if($record->direction == "unknown"){
                $find_mac_direction = Turnstile::where('mac',$record->mac)->value('direction');

                $record->direction = $find_mac_direction;
            }


            if ($record->direction == 'enter') {

                $entryTime  = Carbon::parse($record->date);

                $peopleDailyRecord[$peopleId][$day]['enter'][]= Carbon::parse($record->date)->format('H:i');

            }

             elseif ($record->direction == 'exit' && $entryTime) {

                $peopleDailyRecord[$peopleId][$day]['exit'][] = Carbon::parse($record->date)->format('H:i');

                $exitTime = Carbon::parse($record->date);

                    $entry = explode(' ', $entryTime->toTimeString())[0];
                    $entryT = Carbon::createFromFormat('H:i:s', $entry);


                    $exit = explode(' ', $exitTime->toTimeString())[0];
                    $exitT = Carbon::createFromFormat('H:i:s', $exit);

                    // dump($entryT, $exitT );

                    // Если вход и выход в один день, добавляем разницу
                    if ($exitT->greaterThan($entryT)) {

                        $interval = $exitT->diff($entryT);


                        $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S');
                        // dd($peopleDailyRecord[$peopleId][$day]['working_times']);
                        list($hours, $minutes, $seconds) = explode(':', $interval->format('%H:%I:%S'));
                        $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

                        $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
                        $hours = intdiv($totalMinutes, 60); // Количество часов
                        $minutes = $totalMinutes % 60; // Оставшиеся минуты
                        $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

                    }

                // Сбрасываем время входа после расчета
                $entryTime = null;


            }


        }
        // dd($peopleDailyRecord);
        return ($peopleDailyRecord);

    }
    public function find_schedule_details($peopleDailyRecord, $dailyRecords, $peopleId,$schedule_details, $startTime, $endTime){
          // dd($dailyRecords, $schedule_details);

        $totalHoursWorked = 0;
        $day_working_hours = 0;
        // dd($records);
        // dd($schedule_details);
        foreach($dailyRecords as $date => $records){
            $day = date('d',strtotime($date));
            // dd( $day);//03
            $records = $records->sortBy('date')->unique('date');

            dd($records ->first());
        }

            // foreach($records as $record){
            //     // dd($record->date);
            //     $dayOfWeek = Carbon::parse(time: $record->date)->format('l');
            //     // dd($dayOfWeek);
            //   //    dd($schedule_details[$dayOfWeek]);
            //    $find_working_time = $schedule_details->where('week_day',$dayOfWeek)->first();
            //     // dd( $find_details);
            //     // schedule details
            //     //  "day_end_time" => "09:00:00" "day_start_time" => "18:00:00"
            //     if( $find_working_time->day_end_time<$find_working_time->day_start_time){
            //         // dd($record);
            //             if($record->direction == "enter"){
            //                 dd($record);


            //             }
            //     }


            // }





        foreach ($records as $record) {
            // Assuming $record contains schedule details, such as person_id, start_time, and end_time
            $startTime = Carbon::createFromFormat('H:i:s', $record->day_start_time);
            $endTime = Carbon::createFromFormat('H:i:s', $record->day_end_time);

            // If the end time is earlier than the start time, add one day (for the shift spanning midnight)
            if ($endTime->lessThan($startTime)) {
                $endTime->addDay();
            }

            // Calculate the hours worked for this schedule record
            $hoursWorked = $startTime->diffInHours($endTime);

            // Output or accumulate the hours worked for this record (person)
            echo "Record ID: {$record->id} - Hours Worked: {$hoursWorked} hours\n";

            // Optionally, you can accumulate hours worked across multiple records
            $totalHoursWorked += $hoursWorked;
        }

            return $totalHoursWorked;


    }


}
