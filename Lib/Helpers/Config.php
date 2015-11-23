<?php

namespace App\Lib\Helpers;


/**
 * Class Config
 * @package App\Lib\Helpers
 */
class Config
{

    /**
     * @param $key
     * @return null
     */
    public static function get($key)
    {
        $exp = explode(".", $key);
        if (is_array($exp) && $exp[0] != null && $exp[1] != null && file_exists("config/" . $exp[0] . ".php"))
        {
            $conf = include("config/" . $exp[0] . ".php");
            $val = array_key_exists($exp[1], $conf) ? $conf[$exp[1]] : null;
            return $val;
        }
        return null;
    }

} 