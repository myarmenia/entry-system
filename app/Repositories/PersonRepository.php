<?php

namespace App\Repositories;

use App\DTO\PersonDTO;
use App\Http\Controllers\People\PeopleController;
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
        if(auth()->user()->hasRole(['client_admin','client_admin_rfID'])){

            $client=Client::where('user_id',Auth::id())->first();
            // dd($client);
            if($client!=null){
              return $people= Person::where('client_id',$client->id)->latest()->paginate(10)->withQueryString();

            }
        }else{
            return  $people=Person::latest()->paginate(10)->withQueryString();
        }





    }
    public function createPerson()
    {
        if(auth()->user()->hasRole(['client_admin','client_admin_rfID'])){

            $client = Client::where('user_id',Auth::id())->first();
            if($client!=null){

                $query = EntryCode::where(['client_id'=>$client->id,'activation'=>0])->get();

            }

        }

// dd($query);
        return $query;

    }

    public function storePerson(PersonDTO $personDTO)
    {

        $entry_code = EntryCode::where('id',$personDTO->entry_code_id)->first();

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

            $person_permission_entry_code = PersonPermission::where(['entry_code_id' => $personDTO->entry_code_id,'status' => 1])->first();

            if($person_permission_entry_code){

                $person_permission_entry_code->status = 0;
                $person_permission_entry_code->save();
            }

            $person_permission = new PersonPermission();

            $person_permission->person_id = $person->id;
            $person_permission->entry_code_id = $personDTO->entry_code_id;
            $person_permission->save();

            if($person_permission){

                $entry_code->activation = 1;
                $entry_code->save();

            }

        }





        return $person;


    }
    public function editPerson($personId){

        $person = Person::find($personId);

        return $person;

    }
    public function updatePerson(PersonDTO $personDTO,array $data)
    {
        // dd($personDTO, $data);
            $person = Person::findOrFail($personDTO->id);

            // Update fields based on data from DTO or request
            $person->name = $data['name'] ?? $personDTO->name;
            $person->surname = $data['surname'] ?? $personDTO->surname;
            $person->email = $data['email'] ?? $personDTO->email;
            $person->phone = $data['phone'] ?? $personDTO->phone;
            $person->type = $data['type'] ?? $personDTO->type;

            // Update image if a new one is provided
            if (isset($data['image'])) {
                $path = FileUploadService::upload($data['image'], 'people/' . $person->id);
                $person->image = $path;
            }

            $person->save();

            if ($person) {

                if($personDTO->entry_code_id!=null){

                        $person_permission_old = PersonPermission::where(['person_id'=> $person->id,'status'=>1])->first();
                        if($person_permission_old){
                            $person_permission_old ->status=0;
                            $person_permission_old->save();
                            // Update old entry code activation
                            $old_entry_code = EntryCode::findOrFail($person_permission_old->entry_code_id);
                            $old_entry_code->activation = 0;
                            $old_entry_code->save();

                        }


                            // creating new personPermission
                            $person_permission = new PersonPermission();
                            $person_permission->person_id=$personDTO->id;
                            $person_permission->entry_code_id = $personDTO->entry_code_id;
                            $person_permission->status = 1;
                            $person_permission->save();
                            // Update new entry code activation
                            $entry_code = EntryCode::findOrFail($personDTO->entry_code_id);
                            $entry_code->activation = 1;
                            $entry_code->save();

                }
            }
            return $person;
    }



}
