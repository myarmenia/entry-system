<?php
namespace App\Traits;

use App\Models\AttendanceSheet;
use App\Models\Client;
use App\Models\ClientWorkingDayTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ReportTrait{


    public function report($request){

        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
        $client_working_day_times = ClientWorkingDayTime::where('client_id',$client->id)->select('week_day','day_start_time','day_end_time','break_start_time','break_end_time')->get();
        $people = $client->people->pluck('id');

        if($request->mounth!=null){
            // [$year, $month] = explode('-', $request->mounth);

            // $data = AttendanceSheet::whereIn('people_id',$people)
            // ->whereYear('date', $year)
            // ->whereMonth('date', $month)
            // ->select('people_id', DB::raw('MAX(date) as date'))
            // ->groupBy('people_id')
            // ->get();

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

                $records = DB::table('client_working_day_times')
                            ->where('client_id', $client->id)
                            ->get();
                // dd( $records);



                $workingData = [];

                    foreach ($records as $record) {
                        // Parse times using Carbon
                        $dayStart = Carbon::parse($record->day_start_time);
                        dd($dayStart);
                        $dayEnd = Carbon::parse($record->day_end_time);
                        $breakStart = Carbon::parse($record->break_start_time);
                        $breakEnd = Carbon::parse($record->break_end_time);

                        // Calculate total work time (excluding breaks)
                        $workDuration = $dayEnd->diffInSeconds($dayStart);  // Total time from start to end
                        $breakDuration = $breakStart->diffInSeconds($breakEnd);  // Break time
                        $netWorkDuration = $workDuration - $breakDuration;  // Work time excluding break
                        dd($netWorkDuration);

                        // Calculate lateness if the day start time is later than 9 AM
                        $expectedStartTime = Carbon::parse('09:00:00');
                        $latenessDuration = 0;
                        if ($dayStart->gt($expectedStartTime)) {
                            $latenessDuration = $dayStart->diffInMinutes($expectedStartTime);  // In minutes
                        }

                        // Store the results
                        $workingData[] = [
                            'week_day' => $record->week_day,
                            'worked_hours' => $netWorkDuration / 3600,  // Convert seconds to hours
                            'lateness_minutes' => $latenessDuration,
                        ];
                    }

                    // Example: Print out the working data for each day
                    foreach ($workingData as $data) {
                        echo "Day: {$data['week_day']}, Worked Hours: {$data['worked_hours']} hrs, Lateness: {$data['lateness_minutes']} minutes\n";
                    }


        }


    }
}
