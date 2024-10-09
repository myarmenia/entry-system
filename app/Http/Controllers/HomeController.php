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
    public function index(Request $request)
    {
        // where('user_id', Auth::id())->
        $data = EntryCode::with('person_permissions.people' )
                            ->orderBy('id', 'DESC')->paginate(3)->withQueryString();


        return view("home", compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
