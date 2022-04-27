<?php

namespace tiket_module\Helpers;
class HelperModule
{

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