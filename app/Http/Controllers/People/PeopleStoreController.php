<?php

namespace App\Http\Controllers\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeopleRequest;
use App\Models\Person;
use App\Traits\StoreTrait;
use Illuminate\Http\Request;

class PeopleStoreController extends Controller
{
    use StoreTrait;

   public function model()
   {
      return Person::class;
   }

    public function store(PeopleRequest $request)

    {
        // dd($request->all());
         $data = $this->itemStore($request);

         if($data){

            return redirect()->route('home');
          }

    }
}
