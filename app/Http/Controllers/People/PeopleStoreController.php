<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\EntryCodeRequest;
use App\Models\EntryCode;
use App\Traits\StoreTrait;
use Illuminate\Http\Request;

class PeopleStoreController extends Controller
{
    use StoreTrait;

   public function model()
   {
      return EntryCode::class;
   }

    public function store(EntryCodeRequest $request)

    {
        // dd($request->all());
         $data = $this->itemStore($request);

         if($data){

            return redirect()->route('home');
          }

    }
}
