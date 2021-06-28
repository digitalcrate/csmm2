<?php

namespace App\Api;

class Account
{
    protected $shipperId ;
    protected $username ;
    protected $password ;

    public function __construct( $shipperId, $username, $password )
    {
        $this->shipperId = $shipperId ;
        $this->username = $username ;
        $this->password = $password ;
    }

    public function toXML() {
        return "<Account>
            <ShipperNumber>".$this->shipperId."</ShipperNumber>
            <ShipperUserName>".$this->username."</ShipperUserName>
            <ShipperPass>".$this->password."</ShipperPass>
        </Account>" ;
    }
}