<?php

namespace App\Http\Controllers;

use App\Models\EntryCode;
use App\Models\Person;
use App\Models\PersonPermission;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $data = EntryCode::with('person_permissions.people' )->get();

        return view('home', compact('data'));
    }
}
