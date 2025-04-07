<?php

namespace App\Http\Controllers;

use App\Services\ReportFilterService;
use Illuminate\Http\Request;

class ReportEnterExitController extends Controller
{
    public function __construct(protected ReportFilterService $service){}
    public function __invoke(Request $request){

        $data = $this->service->filterService($request->all());
        // dd($data);

        // $i = 0;
        // // dd($request->all());
        // $mounth = $request->mounth??\Carbon\Carbon::now()->format('Y-m');
        // // dd($mounth);
        // $groupedEntries = $this->calculateReportArmobile($mounth);
        // // dd($groupedEntries);

        // return view('report.index_armobile',compact('groupedEntries','mounth','i'));

        // return view('report.index_armobile',compact('data',));
        return view('report.enter_exit', compact('data'));

    }
}
