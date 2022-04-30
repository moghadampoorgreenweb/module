<?php

class Configuration
{
    private static $data;


    const NUMBER_OFTOKENS_ALLOWED = 100;
    const EXPIRED_TOKEN_MINUTE = 3;
    const TRIES_TOKEN = 3;

    /**
     * @return mixed
     */
    public static function getData()
    {
        return self::$data;
    }

    /**
     * @param mixed $data
     */
    public static function setData($data): void
    {
        self::$data = $data;
    }




}