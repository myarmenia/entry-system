<?php
namespace App\Traits;

use App\Models\ScheduleDetails;
use App\Models\Turnstile;
use Carbon\Carbon;
use DateTime;

trait RecordTrait
{
    public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day){

        $totalSeconds = 0;
        $entryTime = null;  // To store the entry time
        $exitTime = null;
        $woking_array = [];

        $recordsArray = $records->map(function ($item) {
                    return [
                        'date' => $item->date,
                        'direction' => $item->direction
                    ];
                });
                // dd($recordsArray);
                if (!$recordsArray->contains('direction', 'exit') && $recordsArray->contains('direction', 'enter')) {

                    $peopleDailyRecord[$peopleId][$day]['message'] ="Անձի ելքը չի գրանցվել";
                }
                if (!$recordsArray->contains('direction', 'enter')  && $recordsArray->contains('direction', 'exit')) {
                    // If no 'exit' is found, return a message

                    $peopleDailyRecord[$peopleId][$day]['message'] ="Անձի մուտքը չի գրանցվել";
                }


        // dd($records);
        foreach ($records as $key1=>$record) {

            if($record->direction == "unknown"){
                $find_mac_direction = Turnstile::where('mac',$record->mac)->value('direction');

                $record->direction = $find_mac_direction;
                $previouseDirection =$record->direction;
            }

            if ($record->direction == 'enter' && !$entryTime ) {

                $entryTime  = Carbon::parse($record->date);

                $peopleDailyRecord[$peopleId][$day]['enter'][]= Carbon::parse($record->date)->format('H:i');

            }

             elseif ($record->direction == 'exit' && $entryTime) {

                $peopleDailyRecord[$peopleId][$day]['exit'][] = Carbon::parse($record->date)->format('H:i');

                $exitTime = Carbon::parse($record->date);

                $entry = explode(' ', $entryTime->toTimeString())[0];
                // dd($entry);
                $entryT = Carbon::createFromFormat('H:i:s', $entry);
                // dd($entryT);


                $exit = explode(' ', $exitTime->toTimeString())[0];
                $exitT = Carbon::createFromFormat('H:i:s', $exit);

                if ($exitT->lessThan($entryT)) {
                    $exitT->addDay();
                }
                // dump($exitT, $entryT);

                    if ($exitT->greaterThan($entryT)) {
                    // dump($exitT, $entryT);
                        $interval = $exitT->diff($entryT);


                        $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S');
                        // dd($peopleDailyRecord[$peopleId][$day]['working_times']);
                        // list($hours, $minutes, $seconds) = explode(':', $interval->format('%H:%I:%S'));
                        // $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

                        // $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
                        // $hours = intdiv($totalMinutes, 60); // Количество часов
                        // $minutes = $totalMinutes % 60; // Оставшиеся минуты
                        // $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

                        if (isset($records[$key1 + 1]) && $records[$key1 + 1]->direction == "enter") {

                            $entryTime = null;

                        }

                        if( (isset($records[$key1 - 1]) && $records[$key1 - 1]->direction == "exit") ){

                            // $totalSeconds = 0;
                            array_pop($woking_array);

                        }

                        $woking_array[] = $interval->format('%H:%I:%S');
                    }

                // Сбрасываем время входа после расчета
                // $entryTime = null;

            }


        }

        foreach($woking_array as $ar){
            // dd($ar->format('%H:%I:%S'));

            list($hours, $minutes, $seconds) = explode(':',  $ar);
            $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

        }
        // dd($totalSeconds);
        $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
        $hours = intdiv($totalMinutes, 60); // Количество часов
        $minutes = $totalMinutes % 60; // Оставшиеся минуты
        $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";
// dd($peopleDailyRecord);
        return ($peopleDailyRecord);

    }
//     public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day){

//         $totalSeconds = 0;
//         $entryTime = null;  // To store the entry time
//         $exitTime = null;
//         $woking_array = [];

//         $recordsArray = $records->map(function ($item) {
//                     return [
//                         'date' => $item->date,
//                         'direction' => $item->direction
//                     ];
//                 });
//                 // dd($recordsArray);
//                 if (!$recordsArray->contains('direction', 'exit') && $recordsArray->contains('direction', 'enter')) {

//                     $peopleDailyRecord[$peopleId][$day]['message'] ="Անձի ելքը չի գրանցվել";
//                 }
//                 if (!$recordsArray->contains('direction', 'enter')  && $recordsArray->contains('direction', 'exit')) {
//                     // If no 'exit' is found, return a message

//                     $peopleDailyRecord[$peopleId][$day]['message'] ="Անձի մուտքը չի գրանցվել";
//                 }


//         // dd($records);
//         foreach ($records as $key1=>$record) {

//             if($record->direction == "unknown"){
//                 $find_mac_direction = Turnstile::where('mac',$record->mac)->value('direction');

//                 $record->direction = $find_mac_direction;
//                 $previouseDirection =$record->direction;
//             }

//             if ($record->direction == 'enter' ) {

//                 $entryTime  = Carbon::parse($record->date);

//                 $peopleDailyRecord[$peopleId][$day]['enter'][]= Carbon::parse($record->date)->format('H:i');

//             }

//              elseif ($record->direction == 'exit' && $entryTime) {

//                 $peopleDailyRecord[$peopleId][$day]['exit'][] = Carbon::parse($record->date)->format('H:i');

//                 $exitTime = Carbon::parse($record->date);

//                 $entry = explode(' ', $entryTime->toTimeString())[0];
//                 // dd($entry);
//                 $entryT = Carbon::createFromFormat('H:i:s', $entry);
//                 // dd($entryT);


//                 $exit = explode(' ', $exitTime->toTimeString())[0];
//                 $exitT = Carbon::createFromFormat('H:i:s', $exit);

//                     if ($exitT->greaterThan($entryT)) {
//                     dump($exitT, $entryT);
//                         $interval = $exitT->diff($entryT);


//                         $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S');
//                         // dd($peopleDailyRecord[$peopleId][$day]['working_times']);
//                         list($hours, $minutes, $seconds) = explode(':', $interval->format('%H:%I:%S'));
//                         $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

//                         $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
//                         $hours = intdiv($totalMinutes, 60); // Количество часов
//                         $minutes = $totalMinutes % 60; // Оставшиеся минуты
//                         $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

//                         // if (isset($records[$key1 + 1]) && $records[$key1 + 1]->direction == "enter") {

//                         //     $entryTime = null;

//                         // }

//                         // if( (isset($records[$key1 - 1]) && $records[$key1 - 1]->direction == "exit") ){

//                         //     // $totalSeconds = 0;
//                         //     array_pop($woking_array);

//                         // }

//                         // $woking_array[] = $interval->format('%H:%I:%S');
//                     }

//                 // Сбрасываем время входа после расчета
//                 $entryTime = null;

//             }


//         }

//         // foreach($woking_array as $ar){
//         //     // dd($ar->format('%H:%I:%S'));

//         //     list($hours, $minutes, $seconds) = explode(':',  $ar);
//         //     $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

//         // }
//         // // dd($totalSeconds);
//         // $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
//         // $hours = intdiv($totalMinutes, 60); // Количество часов
//         // $minutes = $totalMinutes % 60; // Оставшиеся минуты
//         // $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";
// // dd($peopleDailyRecord);
//         return ($peopleDailyRecord);

//     }





}
