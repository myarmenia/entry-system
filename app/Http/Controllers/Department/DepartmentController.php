<?php

namespace App\Http\Controllers\Department;

use App\DTO\DepartmentDto;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    public function __construct( protected DepartmentService $service){}
    public function index(){

        $data = Department::all();
        $i = 0;

        return view('department.index',compact('data','i'));
    }
    public function create(){

        return view('department.create');

    }
    public function store(Request $request){


        $data = $this->service->store(DepartmentDto::fromRequestDto($request));

        return redirect()->route('department.list');

    }
    public function edit($id){

        $data = $this->service->edit($id);

        return view('department.edit',compact('data'));
    }
    public function update(Request $request,$id){

        $data = $this->service->update( DepartmentDto::fromRequestDto($request),$id);

        return redirect()->back();
    }
}
