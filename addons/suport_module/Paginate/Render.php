<?php

class Render
{
    public static function paginate($page, $out)
    {
        if (isset($page) && $page > 0 && $page < $out) {
            $start = $page;
            $page_counter = $page;
            $next = $page_counter + 1;
            $previous = $page_counter - 1;
            
            return compact('start','page_counter','next','previous');
        }
    }

    public static function page($data)
    {
        return (int)($data->count() / Model::PAGINATE);
    }
}