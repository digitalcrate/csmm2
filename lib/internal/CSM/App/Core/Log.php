<?php
namespace App\Core;

class Log
{
    public static function info( $message )
    {
        $logfile = getcwd().'/var/log/cms.log' ;
        file_put_contents($logfile, date('d/M/Y H:i:s')." > ".$message.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}