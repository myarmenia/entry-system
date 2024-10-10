<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class ChangeStatusService
{
    public static function change_status($request){

        $status = filter_var($request->status, FILTER_VALIDATE_BOOLEAN);

        $data = ['status' => $status];

        $update = DB::table($request->tb_name)
        ->where('id', $request->id)
        ->update([$request->field_name => $status]);

         return $update ? $update : false;
    }
}
