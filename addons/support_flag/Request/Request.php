<?php

class Request
{
    public function validate($request)
    {
        if ( empty($request) | is_null($request)) {
            return true;
        }
        return false;
    }

}