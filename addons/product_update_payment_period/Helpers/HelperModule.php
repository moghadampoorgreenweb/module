<?php

class HelperModule
{
    public static function getTotal($total, $value)
    {
        $value += $total;
        return $value;
    }

    public static function getPercent($percent, $value)
    {
        $percent=trim($percent,'/');
        $percent /= 100;
        $percent *= $value;
        $value += $percent;
        return $value;
    }

}