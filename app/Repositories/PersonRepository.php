<?php

namespace App\Repositories;

use App\DTO\PersonDTO;
use App\Models\Client;
use App\Models\EntryCode;
use App\Models\Person;
use App\Models\PersonPermission;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;

class PersonRepository implements PersonRepositoryInterface
{
    public function getAllPeople()
    {
        return Person::latest()->paginate(10)->withQueryString();
    }
    public function createPerson()
    {
        $client = Client::where('user_id',Auth::id())->first();
        
        return EntryCode::where(['client_id'=>$client->id,'activation'=>0])->get();
    }

    public function storePerson(PersonDTO $personDTO)
    {

        $entry_code=EntryCode::find($personDTO->entry_code_id);

        $person = new Person();
        $person->client_id = $entry_code->client_id;
        $person->name = $personDTO->name;
        $person->surname = $personDTO->surname;
        $person->email = $personDTO->email;
        $person->phone = $personDTO->phone;
        $person->type = $personDTO->type;
        $person->save();

        if($person){

            if($personDTO->image!=null){
               $path = FileUploadService::upload($personDTO->image,  'people/' . $person->id);
               $person->image = $path;
               $person->save();
            }

            $person_permission = new PersonPermission();
            $person_permission->people_id  = $person->id;
            $person_permission->entry_code_id = $personDTO->entry_code_id;
            $person_permission->save();

        }





        return $person;


    }
    public function editPerson($personId){

        return Person::find($personId);


    }

}
