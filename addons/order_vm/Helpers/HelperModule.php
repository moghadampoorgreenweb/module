<?php

namespace order_vm\Helpers;
include __DIR__."/../Response/Response.php";
class HelperModule
{

    const PRODUCT_ID = 9;

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

    public static function addPlanOrder($plan)
    {
        if (isset($plan)) {
            $whereId= \order_vm\Response\Response::whereId($plan);
            $postData = array(
                'clientid' => $_SESSION['uid'],
                'pid' => self::PRODUCT_ID,
                'hostname'=>$whereId['name'] .$whereId['descripion'],
                'priceoverride'=>$whereId['price'],
                'paymentmethod' => 'paypalcheckout',
            );

            $results = localAPI('AddOrder', $postData);
            echo $results;

        }
    }

}