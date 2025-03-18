<?php

namespace App\Http\Controllers\Schedule;

use App\DTO\ScheduleNameDto;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleNameRequest;
use App\Models\Client;
use App\Models\ClientSchedule;
use App\Models\SchedueName;
use App\Models\ScheduleDetails;
use App\Models\ScheduleName;
use App\Models\Staff;
use App\Services\ScheduleNameService;
use Illuminate\Http\Request;


class ScheduleController extends Controller
{
    public function __construct(protected ScheduleNameService $service  ){}
    public function index(){

        // dd(auth()->user()->id);
        if(auth()->user()->hasRole(['client_admin',"client_admin_rfID"])){

            $client_id = Client::where('user_id',auth()->user()->id)->value('id');
        }else{
            $client_id = Staff::where('user_id',auth()->user()->id)->value('client_admin_id');
        }

        // dd($client_id);
        $client_schedules = ClientSchedule::where('client_id',$client_id)->pluck('schedule_name_id');

        $data = ScheduleName::whereIn('id',$client_schedules)->latest()->get();
        // dd( $data);
        $i=0;

        return view('schedule.index', compact('data','i'));

    }
    public function createScheduleNameNew(){

        return view('schedule.createNew',compact('weekdays'));


    }
    public function createScheduleName(){
        $weekdays =MyHelper::week_days();


        return view('schedule.create',compact('weekdays'));
    }
    public function storeScheduleName(ScheduleNameRequest $request){

        $data = $this->service->storeScheduleName(ScheduleNameDto::fromRequestDto($request));
        return redirect()->route('schedule.list');

    }
    public function edit($id){
        // dd($id);
        $weekdays =MyHelper::week_days();

        $data = $this->service->editScheduleName($id);
        // dd($data);
        $schedule_Details = ScheduleDetails::where('schedule_name_id',$id)->get();
        // dd( $schedule_Details);
        return view('schedule.edit',compact('data','weekdays','schedule_Details'));


    }
    public function update(Request $request,$id){
// dd($request->all());
        // dd(ScheduleNameDto::fromRequestDto($request));
        $data = $this->service->updateScheduleName( ScheduleNameDto::fromRequestDto($request),$id);

        return redirect()->back();


    }

}
