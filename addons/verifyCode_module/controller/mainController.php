<?php

/**
 * Created by PhpStorm.
 * User: m.farzaneh
 * Date: 4/28/2018
 * Time: 1:12 PM
 */

class mainController
{
    protected function render($theme, $var = null)
    {

        $header = __DIR__ . "/../theme/header.php";
        $footer = __DIR__ . "/../theme/footer.php";
        $file = __DIR__ . "/../theme/$theme.php";
        if (!file_exists($file)) {
            echo "$theme file is not exist in: $file";
            return false;
        }

        if ($var)
            extract($var);

        require_once $header;
        require_once $file;
        require_once $footer;
    }

    static function loadCss($file)
    {

        return "<link href='" . BASE_URL . "/theme/hrc/css/$file.css' type='text/css' rel='stylesheet'>";
    }
}