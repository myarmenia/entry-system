<?php

namespace App\Http\Controllers;

use App\Http\Resources\PeopleResource;
use App\Models\AttendanceSheet;
use App\Models\Client;
use App\Models\ClientWorkingDayTime;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    protected $model;
    public function __construct()
    {
        // $this->model = $model;
    }
    public function index(Request $request){
        // dd($request->all());
        $attendant="";
        $mounth='';
        $attendant1='';
        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
        $client_working_day_times = ClientWorkingDayTime::where('client_id',$client->id)->select('week_day','day_start_time','day_end_time','break_start_time','break_end_time')->get();
        $people = $client->people->pluck('id');
      
        if($request->mounth!=null){
            [$year, $month] = explode('-', $request->mounth);

            $data = AttendanceSheet::whereIn('people_id',$people)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->select('people_id', DB::raw('MAX(date) as date'))
            ->groupBy('people_id')
            ->get();
            // ->paginate(1);

            $attendant = AttendanceSheet::whereIn('people_id',$people)->get();

            $mounth = $request->mounth;

        }else{

            $data = AttendanceSheet::whereIn('people_id',$people)->get();

        }
        $i=0;

        return view('report.index_new',compact('data','mounth','attendant','client_working_day_times','client','i'));
        // return view('report.index',compact('data','mounth','attendant'))
        // ->with('i', ($request->input('page', 1) - 1) * 1);

    }

}
