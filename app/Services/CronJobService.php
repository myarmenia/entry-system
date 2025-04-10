<?php
namespace App\Services;

use App\Mail\SendEmailClient;
use App\Models\AttendanceSheet;
use App\Models\Client;
use App\Models\Person;
use App\Models\ScheduleDepartmentPerson;
use App\Traits\ScheduleIntervalTrait;
use Illuminate\Support\Facades\Mail;

class CronJobService
{
    use ScheduleIntervalTrait;

    public function get(){

        // $current_day = \Carbon\Carbon::now()->format('Y-m-d');
        // $current_day="2025-03-13";
        $current_day = \Carbon\Carbon::parse("2025-03-15");
        $previous_day = $current_day->subDay()->format('Y-m-d'); // "2025-04-08"
        // dd($current_day);

        $scheduleDepartmentPerson = ScheduleDepartmentPerson::all()->whereNotNull('schedule_name_id')
                                                              ->pluck('person_id')
                                                              ->toArray();
        // dd($scheduleDepartmentPerson);
        $attendance_sheet = AttendanceSheet::whereIn('people_id',$scheduleDepartmentPerson)->get();

        $groupedEntries = $this->getEntriesByScheduleInterval($attendance_sheet);
        // dd($current_day, $previous_day,$groupedEntries);
        foreach ($groupedEntries as $peopleId => $day) {
            if($peopleId == 80){

                if (array_key_exists($previous_day, $day)) {

                    if ($day[$previous_day]) {
                        $recordsArray = $day[$previous_day];
                        // dd($peopleId, $day[$previous_day]);

                        if (!$recordsArray->contains('direction', 'exit') && $recordsArray->contains('direction', 'enter')) {
                            $person = Person::where('id',$peopleId)->first();

                            $client = Client::where('id',$person->client_id)->first();

                            // $client->email
                            $data['client_email'] ="armine.khachatryan1982@gmail.com" ;
                            $data['userFullName'] = $person->full_name;
                            $data['date'] = $previous_day;

                            Mail::send(new SendEmailClient($data));

                        }
                    }
                }
            }
        }

    }

}

