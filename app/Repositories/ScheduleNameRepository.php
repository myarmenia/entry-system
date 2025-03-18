<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\ClientSchedule;
use App\Models\SchedueName;
use App\Models\ScheduleName;
use App\Models\Staff;
use App\Repositories\Interfaces\ScheduleNameInterface;
use Illuminate\Support\Facades\Auth;

class ScheduleNameRepository implements ScheduleNameInterface
{

    public function creat(){

    }
    public function store($dto){


        $data = ScheduleName::create($dto);

        $auth_user_id = Auth::id();

        $client_id = Staff::where('user_id',$auth_user_id)->value('client_admin_id');


        $client = Client::where('user_id',Auth::id())->value('id');


        $clients_schedule = ClientSchedule::create([
            "client_id" => $client_id,
            "schedule_name_id" => $data->id

        ]);


        return $data;


    }
    public function edit($id){
        // dd($id);

        $data = ScheduleName::with('schedule_details')->findOrFail($id);



        return $data;


    }
    public function update($dto, $id){

        $data = ScheduleName::where('id',$id)->first();
        $data->update($dto);

        return true;

    }


}


