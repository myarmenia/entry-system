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


        $data = $request->all();

        $className = $this->model();

        if (class_exists($className)) {

            $model = new $className;

            $relation_foreign_key = $model->getForeignKey();

            $item = $model::create($data);



        return true;



    }



    }


}
