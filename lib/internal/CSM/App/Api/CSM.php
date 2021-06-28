<?php
namespace App\Api;

use App\Config\Config;
use App\Core\Request;

abstract class CSM
{
    protected $account = null ;
    private $request ;
    private $response ;

    public function __construct()
    {
        $this->account = new Account( Config::get("shipperId"), Config::get("username"), Config::get("password") ) ;
    }

    public function getRequest() {
        $this->request = $this->toXML() ;

        // TODO Possible comment this out if we don't require pretty printing or not supported
//        $dom = new \DOMDocument();
//        $dom->preserveWhiteSpace = false;
//        $dom->formatOutput = true;
//        $dom->loadXML($this->request);
//        return $dom->saveXML();
        return $this->request ;
    }

    public function getResponse() {
        return $this->response ;
    }

    protected function request( $url, $debug = false ) {
        $this->response = Request::makeRequest( Config::get("base_url") . $url , $this->getRequest(), null, $debug ) ;
        return $this->response ;
    }

    protected abstract function toXML() ;

}