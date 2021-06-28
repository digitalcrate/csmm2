<?php

namespace App\Config;

use App\Core\Log ;

class Config
{
    protected static $config = [];

    public static function get( $key )
    {
        if( count(static::$config) == 0 ) {
            static::load() ;
        }

        if( !empty(static::$config[$key]) ) {
            return static::$config[$key] ;
        }
        return $key. " - Not Found" ;
    }

    public static function load( $data = [] )
    {
        if (count(static::$config) == 0) {

            static::$config = json_decode(file_get_contents(dirname(__FILE__) . '/config.json'), true);
            static::$config = array_merge( static::$config, $data ) ;

        }
    }
}