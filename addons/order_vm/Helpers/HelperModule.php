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

    public static function addPlanOrder($plan,$data)
    {
        if (isset($plan)) {
            $whereId= \order_vm\Response\Response::whereId($plan);
            $postData = array(
                'clientid' => $_SESSION['uid'],
                'pid' => self::PRODUCT_ID,
                'hostname'=>$whereId['name'] ,
                'priceoverride'=>$whereId['price'],
                'paymentmethod' => 'paypalcheckout',
                'customfields'=>base64_encode(serialize([
                    '4'=>$whereId['opratingsystem']['name'],
                    '5'=>$whereId['region']['name'],
                    '6'=>$whereId['descripion'],
                ])),
            );

            $results = localAPI('AddOrder', $postData);
            echo $results;

        }
    }

}