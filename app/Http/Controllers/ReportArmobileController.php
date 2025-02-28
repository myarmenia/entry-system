<?php

namespace App\Http\Controllers;

use App\Exports\ArmobilExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportArmobileController extends Controller
{
    public function export(Request $request){

        $request=$request->route()->parameters();
        // dd($request);
        $request = $request ?? \Carbon\Carbon::now()->format('Y-m');
// dd($request['mounth']);
        // return Excel::download(new ArmobilExport($request['mounth']), 'armobilReport.xlsx');
        return Excel::download(new ArmobilExport($request['mounth']), 'armobilReport.xlsx');

    }
}
