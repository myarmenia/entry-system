<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use ReportTrait;

    public function calculateReport($mounth){



        $mounth = $mounth ?? \Carbon\Carbon::now()->format('Y-m');
        // dd($mounth);

        $groupedEntries = $this->report($mounth);
        // dd($groupedEntries);

        return $groupedEntries;
    }

    public function index(Request $request){

        $i = 0;

        $mounth = $request->mounth??\Carbon\Carbon::now()->format('Y-m');
        // dd($mounth);

        $groupedEntries = $this->calculateReport($mounth);
        // dd($groupedEntries);

        return view('report.index',compact('groupedEntries','mounth','i'));

    }

    public function export(Request $request)
    {
        $mounth = $request->mounth??\Carbon\Carbon::now()->format('Y-m');
        // dd($mounth);
        // $mounth = "2024-11";
        // dd($mounth);
        // $k=$this->calculateReport($mounth);
        // dd($k);

        return Excel::download(new ReportExport($mounth), 'report.xlsx');
    }

}
