<?php

namespace App\Traits;

use App\Models\EventConfig;
use App\Models\Image;
use App\Models\Person;
use App\Models\PersonPermission;
use App\Models\Product;
use App\Models\ProductTranslation;
use App\Services\FileUploadService;
use App\Services\Log\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UpdateTrait
{
  abstract function model();

  public function itemUpdate(Request $request, $id)
  {
// dd($request->all());
    $data = $request->except([ '_method','name', 'surname','email','phone','image']);

    $className = $this->model();

    if (class_exists($className)) {

      $model = new $className;
      $relation_foreign_key = $model->getForeignKey();

      $table_name = $model->getTable();

      $item = $model::where('id', $id)->first();

      $data['status'] = ($item->status == 0 && $request->has('status')) ? 1 : $data['status'] ?? 0;

        if($item->activation == 0  && $request->has('activation')){
            $data['activation'] = 1;
        }
        if($item->activation == 1  && $request->has('activation')){
            $data['activation'] = 1;
        }
        if ($item->activation == 1 && !request()->has('activation')) {
        $data['activation'] = 0;
        }

      $item->update($data);

      if (isset($request['image'])) {
        // dd($request->all());
        // dd($request['image']);
        if($item->image!=null){
            if (Storage::exists($item->image)) {

            Storage::delete($item->image);
            }
        }

        $path = FileUploadService::upload($request['image'],  $table_name . '/' . $id);

        $item->image = $path;
        $item->save();
      }

      if($item) {
        $clientId=$item->client_id;
        $person=$this->people($request,$clientId, $id);
        if($person){
            return true;
        }
      }



    } else {

      return false;
    }
  }
     public function people($request, $clientId, $entryCodeid){

        $personPermmission=PersonPermission::where('entry_code_id',$entryCodeid)->first();

        if($personPermmission==null){


            $people = new Person;
            $people->client_id = $clientId;
            $people->name = $request->name;
            $people->surname = $request->surname;
            $people->phone = $request->phone;
            $people->email = $request->email;
            $people->save();

            $personPermission = PersonPermission::create([
                'people_id' => $people->id,
                'entry_code_id' => $entryCodeid

            ]);

        }else{

            $peopleData['name'] = $request->name;
            $peopleData['surname'] = $request->surname;
            $peopleData['phone'] = $request->phone;
            $peopleData['email'] = $request->email;

            $person = Person::where('id',$personPermmission->people->id)->first();
            $person->update($peopleData);


        }

        return true;

  }

}
