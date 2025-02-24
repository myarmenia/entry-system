<?php

namespace App\Http\Controllers\Supervised;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Person;
use App\Models\Superviced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervicedController extends Controller
{
    public function superviced_person(Request $request){


        $data = Superviced::create($request->all());
        return response()->json(['message'=>'Գործողությունը հաջողությամբ կատարված է']);

    }
    public function supervised_staff(Request $request){

        $client = Client::where('user_id',Auth::id())->first();

        $supervised = Superviced::where('client_id',$client->id)->pluck('people_id');

        $data = Person::whereIn('id',$supervised)->paginate();

        $i = 0;

        return view('supervised.index',compact('data','i'))->with('i', ($request->input('page', 1) - 1) * 10);;

    }
}
