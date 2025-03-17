<?php

namespace App\Http\Controllers\People;

use App\DTO\PersonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonRequest;
use App\Models\Department;
use App\Models\EntryCode;
use App\Models\Person;
use App\Models\ScheduleName;
use App\Services\PersonService;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $personService;

    public function __construct(PersonService $personService)
    {

        $this->personService = $personService;

    }

    public function index(Request $request)
    {

        $data = $this->personService->getPeopleList();

        return view('people.index', compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 10);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $entry_codes = $this->personService->create();
        $schedule_name = ScheduleName::all();
        $departments = Department::all();
        return view('people.create',compact('entry_codes','schedule_name','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonRequest $request)
    {
        // dd($request->all());

        $personDTO = PersonDTO::fromModel($request);
        
        $data = $this->personService->store($personDTO);

        if($data){

            return redirect()->route('people.index');
        }



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = $this->personService->edit($id);
        $schedule_name = ScheduleName::all();
        $departments = Department::all();

        if($data['person'] != null ){
            return view('people.edit', compact('data','schedule_name','departments'));
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonRequest $request, string $id)
    {

        $person = Person::findOrFail($id);

        $person['entry_code_id'] = $request->entry_code_id;

        $personDTO = PersonDTO::fromModel($person);

        $data = $this->personService->update($personDTO, $request->all());

        if ($data) {
            return redirect()->route('people.index')->with('success', 'Person updated successfully.');
        }

        return redirect()->back()->withErrors('Failed to update the person.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
