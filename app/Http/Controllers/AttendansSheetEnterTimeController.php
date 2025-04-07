<?php

namespace App\Http\Controllers;

use App\Services\AttendanceSheetTimeService;
use Illuminate\Http\Request;

class AttendansSheetEnterTimeController extends Controller
{
    public function __construct(protected AttendanceSheetTimeService $service){}

    public function __invoke($tb_name, $person_id, $client_id, $direction, $date, $day, $time,$existingTime){
        // dd($tb_name,$person_id,$date,$day,$time);
        $data = $this->service->store($tb_name, $person_id, $client_id, $direction, $date, $day, $time,$existingTime);
        return response()->json(['result'=>$data]);
    }
}
