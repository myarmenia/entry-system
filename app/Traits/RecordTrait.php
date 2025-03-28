<?php
namespace App\Traits;

use App\Models\ScheduleDetails;
use App\Models\Turnstile;
use Carbon\Carbon;
use DateTime;

trait RecordTrait
{
    // public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day, $entryTime){

    //     $totalSeconds = 0;

    //     // dd($records);
    //     foreach ($records as $record) {
    //         // dd($record);
    //         // dd($record->schedule_name_id);





    //         if($record->direction == "unknown"){
    //             $find_mac_direction = Turnstile::where('mac',$record->mac)->value('direction');

    //             $record->direction = $find_mac_direction;
    //         }


    //         if ($record->direction == 'enter') {

    //             $entryTime  = Carbon::parse($record->date);

    //             $peopleDailyRecord[$peopleId][$day]['enter'][]= Carbon::parse($record->date)->format('H:i');

    //         }

    //          elseif ($record->direction == 'exit' && $entryTime) {
    //             // dd($entryTime->toTimeString());

    //             $peopleDailyRecord[$peopleId][$day]['exit'][] = Carbon::parse($record->date)->format('H:i');

    //             $exitTime = Carbon::parse($record->date);

    //                 $entry = explode(' ', $entryTime->toTimeString())[0];
    //                 // dd($entry);
    //                 $entryT = Carbon::createFromFormat('H:i:s', $entry);
    //                 // dd($entryT);


    //                 $exit = explode(' ', $exitTime->toTimeString())[0];
    //                 $exitT = Carbon::createFromFormat('H:i:s', $exit);

    //                 // dd($entryT, $exitT );

    //                 // Если вход и выход в один день, добавляем разницу
    //                 if ($exitT->greaterThan($entryT)) {
    //                 // dd($exitT);
    //                     $interval = $exitT->diff($entryT);
    //                     dd($interval );

    //                     $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S');
    //                     // dd($peopleDailyRecord[$peopleId][$day]['working_times']);
    //                     list($hours, $minutes, $seconds) = explode(':', $interval->format('%H:%I:%S'));
    //                     $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

    //                     $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
    //                     $hours = intdiv($totalMinutes, 60); // Количество часов
    //                     $minutes = $totalMinutes % 60; // Оставшиеся минуты
    //                     $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

    //                 }

    //             // Сбрасываем время входа после расчета
    //             $entryTime = null;


    //         }


    //     }
    //     // dd($peopleDailyRecord);
    //     return ($peopleDailyRecord);

    // }

    public function getPersonWorkingHours($peopleDailyRecord,$records, $peopleId,$day, $entryTime){
       // dd($records, $peopleId,$day);
        $totalSeconds = 0;
        // dd($day,$records);
        // dd($records->pluck('date','direction'));
        $recordsArray = $records->map(function ($item) {
            return [
                'date' => $item->date,
                'direction' => $item->direction
            ];
        });
        // dd($recordsArray);

        // dd($recordsArray->groupBy('direction'));
        $results = [];
        $grouped = $recordsArray->groupBy('direction');
        // dd( $grouped);
        $daily_working_times = '';

        if (isset($grouped['enter']) && isset($grouped['exit'])) {
            $enterRecords = $grouped['enter'];
            $exitRecords = $grouped['exit'];

            foreach ($enterRecords as $index => $enterRecord) {
                if (isset($exitRecords[$index]) ) {
                    $entryT = Carbon::parse($enterRecord['date']);
                    $exitT = Carbon::parse($exitRecords[$index]['date']);
                    // dd($exitT, $entryT);
                    // if( $exitTime > $enterTime){

                            // $timeDifference = $entryT->diffInSeconds($exitT); // Разница в минутах
                            // dd($timeDifference->format('%H:%I:%S'));
                    //         $totalSeconds += $timeDifference;
                    //         dump($day, $enterTime, $exitTime,$totalSeconds);

                    //         // $results[] = [
                    //         //     'enter' => $entryT->toDateTimeString(),
                    //         //     'exit' => $exitT->toDateTimeString(),
                    //         //     'difference' => $timeDifference . ' minutes',
                    //         // ];
                    // }
                    // if ($exitT->greaterThan($entryT)) {
                    //                     // dd($exitT);
                    //                         $interval = $exitT->diff($entryT);
                    //                         // dd($interval );

                    //                    dd( $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S'));
                    // }
                    if ($exitT->greaterThan($entryT)) {
                                        // dd($exitT);
                                            $interval = $exitT->diff($entryT);
                                            // dd($interval );

                                            $peopleDailyRecord[$peopleId][$day]['working_times'][] = $interval->format('%H:%I:%S');
                                            // dd($peopleDailyRecord[$peopleId][$day]['working_times']);
                                            list($hours, $minutes, $seconds) = explode(':', $interval->format('%H:%I:%S'));
                                            $totalSeconds += $hours * 3600 + $minutes * 60 + $seconds;

                                            $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
                                            $hours = intdiv($totalMinutes, 60); // Количество часов
                                            $minutes = $totalMinutes % 60; // Оставшиеся минуты
                                            $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

                                        }
                }
            }
        }

        // dd($totalSeconds);

                            // $totalMinutes = intdiv($totalSeconds, 60); // Общее количество минут
                            //  // dd($totalMinutes);
                            // $hours = intdiv($totalMinutes, 60); // Количество часов
                            // $minutes = $totalMinutes % 60; // Оставшиеся минуты
                            // // dd($hours);
                            // $peopleDailyRecord[$peopleId][$day]['daily_working_times']= "{$hours} ժ {$minutes} ր";

        return ($peopleDailyRecord);

    }




}
