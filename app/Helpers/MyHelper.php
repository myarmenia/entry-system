<?php

namespace App\Helpers;

class MyHelper
{
    public static function binaryToDecimal($binaryString)
    {
        $substring = substr($binaryString, 9, 16); // Индексы начинаются с 0, поэтому берем с 9 символа и длиной 16

        // Преобразуем бинарную подстроку в десятичное число
        $decimal = bindec($substring);

        return $decimal;
    }


}
