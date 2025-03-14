<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleDetailsRequest;
use App\Services\ScheduleDetailsService;
use Illuminate\Http\Request;

class ScheduleDetailsController extends Controller
{
    public function __construct(protected ScheduleDetailsService $service){}
    public function update(ScheduleDetailsRequest $request,$id){
        // dd($request->all());

        $data=$this->service->update($request->all(),$id);

        return redirect()->route('schedule.edit',$id);




    }
}
