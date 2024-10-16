<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSheet;
use DateTime;
use Illuminate\Http\Request;

class GetDayReservationsController extends Controller
{
    public function __invoke($people_id,$data){


        $reservetions= AttendanceSheet::where('people_id',$people_id)->whereDate('date',$data)->get();

        if ($reservetions) {

            return view('components.offcanvas', ['reservetions' => $reservetions]);
          }


    }
}
