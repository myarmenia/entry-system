<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportCotroller extends Controller
{
    public function index(){

        $data = Client::where('user_id', Auth::id())->with('people.attendance_sheets')->first();
   
        return view('report.index');

    }
}
