<?php
namespace App\Core;

use App\Core\Log ;

class Request
{
    public static function makeRequest( $url, $body, $headers = [], $debug = false ) {

        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL, $url ) ;
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 ) ;
        curl_setopt($ch, CURLOPT_TIMEOUT, 45 ) ;
        curl_setopt($ch, CURLOPT_POST, true ) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body ) ;
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers ) ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));

        $response = curl_exec( $ch ) ;
        $error = curl_error( $ch ) ;
        curl_close($ch) ;


        //if( $debug ) {
            \App\Core\Log::info( "CSM Request: " . $url ) ;
            \App\Core\Log::info( print_r($body, true) ) ;
            \App\Core\Log::info( "CSM Response:" ) ;
            \App\Core\Log::info( print_r($response, true) ) ;
        //}

        if( $error ) {
            \App\Core\Log::info("cURL Error: " . $error ) ;
            return null ;
        }

        return $response ;

    }
}