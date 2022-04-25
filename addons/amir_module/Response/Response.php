<?php

namespace amir_module\Response;

class Response
{
    public static function success()
    {
        return [
            'status'=>201,
        ];
    }

}