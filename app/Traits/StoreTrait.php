<?php
namespace App\Traits;

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

        $data = $request->except('image');

        $className = $this->model();

        if (class_exists($className)) {

            $model = new $className;

            $relation_foreign_key = $model->getForeignKey();
            $table_name = $model->getTable();


            $item = $model::create($data);

            // if ($photo = $request['image'] ?? null) {
            //     $path = FileUploadService::upload($request['image'], $table_name . '/' .$item->id);

            //         $item->image = $path;
            //         $item->save();
            //         $filePath = 'private/' . $path;
            //         // dd($filePath);
            //         if (Storage::disk('local')->exists($path)) {
            //             // dd(888);
            //             // Serve the file as a response (to display or download it)
            //             return true;
            //         } else {
            //             dd(777);
            //             // Handle the case where the file doesn't exist
            //             return abort(404, 'File not found.');
            //         }

            // }

        return true;



    }



    }


}
