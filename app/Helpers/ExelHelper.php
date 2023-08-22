<?php

namespace App\Helpers;

class ExcelHelper
{
    public static function titleToNumber($title)
    {
        $title = strtoupper($title);
        $length = strlen($title);
        $result = 0;

        for ($i = 0; $i < $length; $i++) {
            $char = ord($title[$i]) - ord('A') + 1;
            $result = $result * 26 + $char;
        }

        return $result;
    }
}
