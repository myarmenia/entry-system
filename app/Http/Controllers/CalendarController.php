<?php

namespace App\Http\Controllers;

use App\Http\Resources\GetCalendarResource;
use App\Models\AttendanceSheet;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function __invoke($id){

        // $data=AttendanceSheet::where('people_id',$id)->get();



        return view('calendar.index');
    }
}
