<?php
namespace App\Traits;

use App\Models\Client;
use App\Models\EntryCode;
use App\Models\PersonPermission;
use App\Services\FileUploadService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

trait StoreTrait
{

    abstract function model();

    public function itemStore( $request)
    {

        if(auth()->user()->hasRole('client_admin')){
            $client=Client::where('user_id',Auth::id())->first();
            $request['type']="faceID";
            $request['client_id'] =$client->id;

            if( $request->has('activation')){
                $request['activation'] = 1;
            }
            if( !$request->has('activation')){
                $request['activation'] = 0;
            }

        }

        $data = $request->all();

        $className = $this->model();

        if (class_exists($className)) {

            $model = new $className;
            $entry_code = EntryCode::where(['token'=>$request->token,'client_id'=>$request->client_id])->first();
            if($entry_code){

                session()->flash('repeating_token', 'Թոքենը կրկնվում է');

                return redirect()->back();
            }


            $item = $model::create($data);
            session()->flash('success', 'Թոքենը ստեղծվել է');
        return true;

    }



    }


}
