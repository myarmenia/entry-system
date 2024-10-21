<?php

namespace App\Services;

use App\Models\EntryCode;
use App\Services\Log\LogService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeleteItemService
{
  public static function delete($tb_name, $id)
  {

      $className = 'App\Models\\' . Str::studly(Str::singular($tb_name));

      $model = '';

      if(class_exists($className)) {
          $model = new $className;

      }


      if(!is_string($model)){

          $item = $model->where('id', $id);

          $file_path = '';
          $item_db = $item->first();


          if(isset($item_db->image)){
            Storage::disk('public')->deleteDirectory("$tb_name/$id");

          }
          else{

                if(isset($item_db->logo)){
                    $file_path = $item_db->logo;
                }

                if(isset($item_db->video)){
                  $file_path = $item_db->video;
                }
                if(isset($item_db->path)){
                  $file_path = $item_db->path;
                }

                Storage::delete($file_path);
          }


        if($tb_name == 'people'){
                  $item_db->activated_code_connected_person();
                  if($item_db->activated_code_connected_person !=null){
                    $item_db->activated_code_connected_person->status = 0;
                    $item_db->activated_code_connected_person->save();

                    $entry_code = self::entryCodeChangeStatus($item_db->activated_code_connected_person->entry_code_id);
                  }
              }

          $delete = $item ? $item->delete() : false;

        //   $delete ? LogService::store(null, $id, $tb_name, 'delete') : '';


      return $delete;
      }

  }
  public static function entryCodeChangeStatus($entryCodeId){

    $entry_code = EntryCode::where('id',$entryCodeId)->first();
    $entry_code->activation = 0;
    $entry_code->save();

  }
}
