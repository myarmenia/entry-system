<?php

namespace App\Http\Controllers\EntryCode;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class EntryCodeCreateController extends Controller
{
    public function __invoke()
    {

        $clients = Client::with('user')->get();

        return view('entryCode.create',compact('clients'));
    }
}
