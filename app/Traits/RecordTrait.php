<?php
namespace App\Traits;

use App\Models\Turnstile;
use Carbon\Carbon;

trait RecordTrait
{
    public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day, $entryTime){

        $totalSeconds =0;
        // dd($records);
        foreach ($records as $record) {



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
                        $peopleDailyRecord[$peopleId][$day]['daily_working_times']= $totalSeconds;

                    }

                // Сбрасываем время входа после расчета
                $entryTime = null;


            }


        }
        // dd($peopleDailyRecord);
        return ($peopleDailyRecord);

    }


}
