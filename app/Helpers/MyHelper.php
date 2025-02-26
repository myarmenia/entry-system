<?php

namespace App\Helpers;

use App\Models\Client;
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

   
}
