<?php
/**
 * Created by PhpStorm.
 * User: m.farzaneh
 * Date: 5/6/2018
 * Time: 7:13 AM
 */
if (!function_exists('my_array_unique')){
    function my_array_unique($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp         = array();

        foreach ($array as $key=>$val)
        {
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
}
