<?php

namespace App\Api;

class Tracking extends CSM
{
    public $consignmentNumber = "" ;
    public $events = [] ;

    public function track( $consignmentNumber, $lastOnly = false ) {
        $this->consignmentNumber = $consignmentNumber ;
        //$data = $this->request("Track/") ;

        // call to grass boots to get the data
        $json = $this->getTracking( $consignmentNumber ) ;

        $events = [] ;

        $data = json_decode($json, true);

        $lastEvent = null ;

        if( isset($data["status"]) && $data["status"] == "ok" ) {

            foreach( $data["events"] as $id => $event ) {
                $createdDate = $event["date"] ;
                $consignmentStatus = $event["status"] ;
                $pickupDate = !empty($event["pickup"]) ? $event["pickup"] : null ;
                $deliveryDate = !empty($event["delivered"]) ? $event["delivered"] : null ;
                $tracking_event = new TrackingEvent( $createdDate, $this->consignmentNumber, $consignmentStatus, $pickupDate, $deliveryDate ) ;
                $events[] = $tracking_event ;
                if( $lastEvent == null ) {
                    $lastEvent = $tracking_event ;
                }
            }
        }

        return $lastOnly ? $lastEvent : $events ;

    }

    protected function toXML() {

        $xml = "<Request xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
                            <RequestAction>Track</RequestAction>" ;

        $xml .= $this->account->toXML() ;

        $xml .= "<Consignment>
                    <ConsignmentNumber>".$this->consignmentNumber."</ConsignmentNumber>
                </Consignment></Request>" ;

        return $xml ;
    }

    private function getTracking( $tracking, $shipper = null, $username = null, $password = null) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.grass-boots.com/CSM/track.php?tracking=" . $tracking );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Authorization: asckm88653[~r'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        return $server_output ;

    }


}