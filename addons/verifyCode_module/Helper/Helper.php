<?php

namespace verifyCode_module\Helper;

use Respect\Validation\Validator as v;

class Helper
{

    public function getClients()
    {
        $results = localAPI('GetClients');

        return collect($results['clients']['client'])->map(function ($item) {
            $postData = array(
                'clientid' => $item['id'],
                'stats' => true,
            );
            return localAPI('GetClientsDetails', $postData);
        });
    }

    public function wherePhoneClient($phone)
    {

      return  collect($this->getClients())->where('phonenumber','=',$phone)->first();
    }


    public function getClient($email)
    {

        $command = 'GetClients';
        $postData = array(
            'search' => $email,
        );
        $results = localAPI($command, $postData);

        if (empty($results['result']) && is_null($results['result'])) {

            return false;
        }
        if ($results['totalresults'] == 0) {

            return false;
        }

        return $results['clients']['client'][0];
    }

    public function getCode()
    {
        $code = round(rand(1000, 9999), 10);

        return $code;
    }

    public function validateEmail($request)
    {

        return v::email()->validate($request);
    }

    public function requestMethod($method)
    {
        if ($_SERVER["REQUEST_METHOD"] != $method) {
            Response::errore(400, "The request must be in the form of a {$method} ");
            die;
        }
    }

}