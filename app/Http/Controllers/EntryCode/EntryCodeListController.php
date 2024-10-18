<?php

namespace App\Http\Controllers\EntryCode;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\EntryCode;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntryCodeListController extends Controller
{
    public function index(Request $request){

        $user = auth()->user();

        $query = EntryCode::latest();

        if ($user->hasRole('client_admin')) {

            $client = Client::where('user_id', $user->id)->first();

            if ($client) {
                $query->where('client_id', $client->id);
            }
        }
        $data = $query->paginate(10)->withQueryString();


          return view('entrycode.index', compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);

    }
}
