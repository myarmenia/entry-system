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
        $k=$this->calculateReport($mounth);

        return Excel::download(new ReportExport($mounth), 'report.xlsx');
    }

}
