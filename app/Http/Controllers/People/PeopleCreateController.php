<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PeopleCreateController extends Controller
{
    public function __invoke()
    {
   
        return view('people.create');
    }
}
