<?php

namespace App\Api\Enum;

class ShippingStatus
{
    const CREATED = 0 ;
    const COLLECTED = 1 ;
    const IN_TRANSIT = 2 ;
    const OUT_FOR_DELIVERY = 3 ;
    const DELIVERED = 4 ;
    const EXCEPTION = 5 ;

    public static function getStatus( $int ) {

        $statuses = [
            ShippingStatus::CREATED => "Created",
            ShippingStatus::COLLECTED => "Collected",
            ShippingStatus::IN_TRANSIT => "In Transit",
            ShippingStatus::OUT_FOR_DELIVERY => "Out for Delivery",
            ShippingStatus::DELIVERED => "Delivered",
            ShippingStatus::EXCEPTION => "Exception",
        ] ;

        return $statuses[$int] ;

    }
}