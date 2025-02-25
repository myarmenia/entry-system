<?php

namespace App\Http\Controllers;

use App\Exports\ArmobilExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportArmobileController extends Controller
{
    public function export(){
        $mounth = $request->mounth??\Carbon\Carbon::now()->format('Y-m');
        

        return Excel::download(new ArmobilExport($mounth), 'armobilReport.xlsx');

    }
}
