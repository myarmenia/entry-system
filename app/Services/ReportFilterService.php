<?php
namespace App\Services;

use App\Helpers\MyHelper;
use App\Models\AttendanceSheet;
use App\Traits\ReportFilterTrait;
use Carbon\Carbon;

class ReportFilterService

{
    use ReportFilterTrait;

    public function __construct(protected AttendanceSheet $model){}
    public function filterService($data){


        $data['month'] = $data['month'] ??\Carbon\Carbon::now()->format('Y-m');
        $department_id = $data['department_id'] ?? null;
        // dd($department_id);

        $attendance_sheet = AttendanceSheet::forClient($data['month'], $department_id)->get();
        // dd($attendance_sheet);
        $data['attendance_sheet'] = $attendance_sheet;
        $data['client_department'] = Myhelper::get_client_department();
        $data['client_id'] = Myhelper::find_auth_user_client();

        $service = $this->filter($data);


        return $data;

    }

}
