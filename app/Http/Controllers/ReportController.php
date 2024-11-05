<?php

namespace App\Http\Controllers;

use App\Http\Resources\PeopleResource;
use App\Models\AttendanceSheet;
use App\Models\Client;
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
$attendant="";
$mounth='';
        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();

        $people = $client->people->pluck('id');
        if($request->mounth!=null){
            [$year, $month] = explode('-', $request->mounth);

            $data = AttendanceSheet::whereIn('people_id',$people)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->select('people_id', DB::raw('MAX(date) as date'))
            ->groupBy('people_id')
            ->get();

            $attendant = AttendanceSheet::whereIn('people_id',$people)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->select('people_id', DB::raw('MAX(date) as date'))
            ->groupBy('people_id','date')
            ->get();
            // dd($attendant);

            // dd($data,$attendant);


            $mounth = $request->mounth;

        }else{

            $data = AttendanceSheet::whereIn('people_id',$people)->get();

        }

        return view('report.index',compact('data','mounth','attendant'));

    }
    public function report(Request $request){

       [$year, $month] = explode('-', $request->mounth);


        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
        $people = $client->people->pluck('id');
              $data = AttendanceSheet::whereIn('people_id',$people)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->get();



        return view('report.index',compact('data'));


    }
}
