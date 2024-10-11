<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\EntryCode;
use App\Models\Person;
use App\Models\PersonPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $client = Client::where('user_id',Auth::id())->first();

        if($client){
            $data = EntryCode::where('client_id',$client->id)->with('people')
                                ->orderBy('id', 'DESC')->paginate(3)->withQueryString();

        }

// dd($data);
        // $data = EntryCode::orderBy('id', 'DESC')->paginate(3)->withQueryString();


        return view("home", compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 10);
    }
}
