<?php

namespace App\Api;

class Address
{
    const SHIP_FROM = "ShipFrom" ;
    const SHIP_TO = "ShipTo" ;
    const SOLD_TO = "SoldTo" ;

    public $type = "ShipFrom";
    public $companyName = "" ;
    public $contactName = "" ;
    public $contactPhone = "" ;
    public $contactEmail = "" ;
    public $houseNumber = "" ;
    public $address1 = "" ;
    public $address2 = "" ;
    public $address3 = null ;
    public $town = null ;
    public $county = null ;
    public $postcode = null ;
    public $isoCountryCode = null ;

    public function __construct( $type )
    {
        $this->type = $type ;
    }

    public function toXML() {

        return "<".$this->type.">
                    <CompanyName>".$this->companyName."</CompanyName>
                    <ContactName>".$this->contactName."</ContactName>
                    <ContactPhone>".$this->contactPhone."</ContactPhone>
                    <ContactEmail>".$this->contactEmail."</ContactEmail>
                    <Address>
                        <HouseNumber>".$this->houseNumber."</HouseNumber>
                        <AddressLine1>".$this->address1."</AddressLine1>
                        <AddressLine2>".$this->address2."</AddressLine2>
                        <AddressLine3>".$this->address3."</AddressLine3>
                        <Town>".$this->town."</Town>
                        <County>".$this->county."</County>
                        <PostCode>".$this->postcode."</PostCode>
                        <ISOCountryCode>".$this->isoCountryCode."</ISOCountryCode>
                    </Address>
                 </".$this->type.">" ;
    }
}