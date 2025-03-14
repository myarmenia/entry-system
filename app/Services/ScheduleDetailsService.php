<?php
namespace App\Services;

use App\Repositories\Interfaces\ScheduleDetailsInterface;

class  ScheduleDetailsService
{
    protected $scheduleDetailsRepository;
    public function __construct(ScheduleDetailsInterface $scheduleDetailsRepository){

        $this->scheduleDetailsRepository = $scheduleDetailsRepository;
    }

    public function update($request,$id){

        $data = $this->scheduleDetailsRepository->update($request,$id);


    }

}
