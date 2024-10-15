<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSheet;
use DateTime;
use Illuminate\Http\Request;

class GetDayReservationsController extends Controller
{
    public function __invoke($people_id,$data){
// dd($data);

        $datas = AttendanceSheet::where(['people_id'=>$people_id])->get();

        $day_array=[];
        foreach($datas as $attend){
// dd($data,$attend->date);
        $date_string = $attend->date;
        $date = new DateTime($date_string);
        $formatted_date = $date->format('Y-m-d');
            // dd($formatted_date);
            if ($data==$formatted_date){
                $day_array[] = $attend->id;

            }
        }
       $reservetions = AttendanceSheet::whereIn('id', $day_array)->get();
// dd($reservetions);
        if ($reservetions) {
            // dd($reservetions);

            // return response()->json($reservetions);
            return view('components.offcanvas', ['reservetions' => $reservetions]);
          }


    }
}
