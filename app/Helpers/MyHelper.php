<?php

namespace App\Helpers;

use App\Models\Client;
use App\Models\Staff;
use App\Models\Superviced;
use Illuminate\Support\Facades\Auth;

class MyHelper
{
    public static function binaryToDecimal($binaryString)
    {
    //    dd($binaryString);
        $substring = substr($binaryString, 9, 16); // Индексы начинаются с 0, поэтому берем с 9 символа и длиной 16
// dd($substring);
        // Преобразуем бинарную подстроку в десятичное число
        $decimal = bindec($substring);
// dd($decimal);
        return $decimal;
    }
    public static function week_days(){

        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday','Saturday','Sunday'];

        return $weekdays;
    }


    public static function find_auth_user_client (){

        if(auth()->user()->hasRole(['client_admin','client_admin_rfID'])){

            $client_id = Client::where('user_id',Auth::id())->value('id');
        }
        else{
            $client_id = Staff::where('user_id',Auth::id())->value('client_admin_id');

        }
        return $client_id;

    }


}
