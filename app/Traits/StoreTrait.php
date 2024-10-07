<?php
namespace App\Traits;

use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait StoreTrait
{

    abstract function model();

    public function itemStore( $request)
    {
        // dd($request);
        $data = $request->except(['token', 'number', 'type','image','activation']);

        $className = $this->model();

        if (class_exists($className)) {

        $model = new $className;
        $relation_foreign_key = $model->getForeignKey();
        $table_name = $model->getTable();

        if (in_array('user_id', Schema::getColumnListing($table_name))) {
            $data['user_id'] = Auth::id();

        }


        $item = $model::create($data);

            if ($item) {

                if ($photo = $request['image'] ?? null) {
                $path = FileUploadService::upload($request['image'], $table_name . '/' . $item->id);
                $photoData = [
                    'path' => $path,
                    'name' => $photo->getClientOriginalName()
                ];
dd($item);
                $item->entry_code()->create($photoData);
                }




                return true;
            }
            return true;
        }
    }


}
