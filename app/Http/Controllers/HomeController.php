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

        $client = Client::where('user_id',Auth::id())->first();
        $query = EntryCode::with('people')->orderBy('id', 'DESC');


        if ($client) {
            $query->where('client_id', $client->id);
        }

        $data = $query->paginate(10)->withQueryString();

        return view("home", compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 10);




    }
}
