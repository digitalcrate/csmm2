<?php

namespace App\Api;

class TrackingEvent
{
    public $createdDate = null ;
    public $consignmentNumber = "" ;
    public $consignmentStatus = "" ;
    public $pickupDate = null ;
    public $deliveryDateTime = null ;

    public function __construct( $createdDate, $conNo, $conStatus, $pickupDate, $deliveryDateTime )
    {
        $this->createdDate = $createdDate ;
        $this->consignmentNumber = $conNo ;
        $this->consignmentStatus = $conStatus ;
        $this->pickupDate = $pickupDate ;
        $this->deliveryDateTime = $deliveryDateTime ;
    }

}