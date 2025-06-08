<?php
namespace App\Helpers;

class GenerateHelper
{
    public static function generateCode($digit)
    {
        $characters = '0123456789';
        $code = '';
        for ($i = 0; $i < $digit; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        $code = "MRN-" . $code;
        return $code;
    }
}
