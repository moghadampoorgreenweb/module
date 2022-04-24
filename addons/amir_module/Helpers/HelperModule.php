<?php

namespace amir_module\Helpers;
class HelperModule
{
    public static function getTotal($total, $value)
    {
        $value += $total;
        return $value;
    }

    public static function getPercent($percent, $value)
    {
        $percent = trim($percent, '/');
        $percent /= 100;
        $percent *= $value;
        $value += $percent;
        return $value;
    }

    public static function getClients()
    {
        return collect(localAPI('GetClients')['clients']['client']);
    }

    public static function whereClients($key, $value, $oprator = null)
    {
        return (self::getClients())->where($key, $oprator, $value);
    }

    public static function whereClientDetails($id)
    {
        $postData = array(
            'clientid' => $id,
            'stats' => true,
        );

        return localAPI('GetClientsDetails', $postData);
    }
}