<?php

namespace App\Repositories;

use App\Interfaces\DepartmentInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentInterface
{

    public function store($dto){

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
