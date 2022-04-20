<?php

class Response
{
    public static function errore($code, $body)
    {
        print json_encode([
            "errors" => [
                "status" => $code,
                "detail" => $body,
            ],
        ]);
    }

    public static function success($code, $body)
    {
        print json_encode([
            "response" => [
                "status" => $code,
                "detail" => $body,
            ],
        ]);
    }


}