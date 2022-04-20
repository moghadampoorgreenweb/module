<?php

include_once __DIR__.'/../Config/Configuration.php';

use \suport_module\Config\Configuration;
class Import
{

    public static function importExel($nameFile,$tmp_name)
    {
        if (empty($nameFile) && $nameFile==null || empty($tmp_name) && $tmp_name==null){

            return false;
        }
        $target=Configuration::BASEFILE.basename($nameFile);

        move_uploaded_file($tmp_name ,$target);
    }
}