<?php

class EmailService
{

    public function emailApi($userID, $token)
    {
        $command = 'SendEmail';
        $postData = [
            '//example1' => 'example',
            'messagename' => 'Client Signup Email',
            'id' => $userID,
            '//example2' => 'example',
            'customtype' => 'product',
            'customsubject' => 'Product Welcome Email',
            'custommessage' => '<p>Thank you for choosing us</p><p>Your custom is appreciated</p><p>{$custommerge}<br /></p>',
            'customvars' => base64_encode(serialize(["custommerge" => $token])),
        ];

        $results = localAPI($command, $postData);
        return $results;
    }

}