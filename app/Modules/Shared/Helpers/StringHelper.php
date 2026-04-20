<?php

namespace App\Modules\Shared\Helpers;

class StringHelper
{
    public static function truncate($string, $length = 100, $suffix = '...')
    {
        return strlen($string) > $length ? substr($string, 0, $length) . $suffix : $string;
    }

    public static function slugify($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}
