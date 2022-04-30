<?php

include __DIR__ . "/../";


class EmailService
{

    public function emailApi($userID, $token)
    {
        $template=Configuration::getData();
        $command = 'SendEmail';
        $postData = [
            'messagename' => $template['template Name'],
            'id' => $userID,
            'customvars' => base64_encode(serialize(["token" => $token])),
        ];

        $results = localAPI($command, $postData);
        return $results;
    }

}