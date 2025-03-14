<?php

namespace App\Repositories;

use App\Models\SchedueName;
use App\Models\ScheduleName;
use App\Repositories\Interfaces\ScheduleNameInterface;

class ScheduleNameRepository implements ScheduleNameInterface
{

    public function creat(){

    }
    public function store($dto){


        $data = ScheduleName::create($dto);
        return $data;


    }
    public function edit($id){

        $data = ScheduleName::findOrFail($id)->with('schedule_details')->first();


        return $data;


    }
    public function update($dto, $id){

        $data = ScheduleName::where('id',$id)->first();
        $data->update($dto);

        return true;

    }


}


