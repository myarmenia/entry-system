<?php
namespace App\Services;

use App\Helpers\MyHelper;
use App\Models\AttendanceSheet;
use Carbon\Carbon;

class ReportFilterService

{

    public function __construct(protected AttendanceSheet $model){}
    public function filterService($data){

        $data['mounth'] = $request->mounth??\Carbon\Carbon::now()->format('Y-m');
        // dd($data['mounth']);
        // $data['client_id'] = MyHelper::find_auth_user_client();

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $attendance_sheet = AttendanceSheet::forClient($data['mounth'])->get();
        dd($$attendance_sheet);
        $data['attendance_sheet'] = $attendance_sheet;


        $groupedEntries = $attendance_sheet->groupBy(['people_id', function ($oneFromCollection) {
            return Carbon::parse($oneFromCollection->date)->toDateString();
        }]);
        // dd( $groupedEntries);

        $data = $this->model
        ->filter($data);



        return $data;

    }

}
