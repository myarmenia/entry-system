<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSheet;
use App\Models\Client;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    protected $model;
    public function __construct()
    {
        // $this->model = $model;
    }
    public function index(Request $request){
// dd($request->all());
        $client = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
  $people = $client->people->pluck('id');
        $data = AttendanceSheet::whereIn('people_id',$people)->get();

        // $data = $this->model
        //                ->filter($request->all());



        return view('report.index',compact('data'));

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
