<?php

namespace App\Repositories;

use App\Interfaces\DepartmentInterface;
use App\Models\Department;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class DepartmentRepository implements DepartmentInterface
{

    public function store($dto){

        $client_id = Staff::where('user_id',Auth::id())->value('client_admin_id');
        $dto['client_id']=$client_id;

        $data = Department::create($dto);

        return true;
    }
    public function edit($id){

        $data = Department::find($id);

        return $data;
    }
    public function update($dto,$id){

        $data = Department::where('id',$id)->first();

        $data->update($dto);

        return $data;

    }
}
