<?php

namespace App\Modules\Shared\Helpers;

class DateHelper
{
    public static function toUserTimezone($datetime, $timezone)
    {
        return $datetime ? $datetime->setTimezone($timezone) : null;
    }

    public static function formatDate($datetime, $format = 'Y-m-d H:i:s')
    {
        return $datetime ? $datetime->format($format) : null;
    }
}
