<?php

namespace App\Http\Controllers\EntryCode;

use App\Http\Controllers\Controller;
use App\Models\EntryCode;
use Illuminate\Http\Request;

class EntryCodeEditController extends Controller
{
    public function edit($id){

        $data= EntryCode::where('id',$id)->with('person_permissions.people')->first();
       return view('entryCode.edit', compact('data'));
   }
}
