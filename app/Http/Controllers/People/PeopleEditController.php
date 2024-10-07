<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Models\EntryCode;
use Illuminate\Http\Request;

class PeopleEditController extends Controller
{
    public function edit($id){
         $data= EntryCode::where('id',$id)->with('person_permissions.people')->first();

        return view('people.edit', compact('data'));
    }
}
