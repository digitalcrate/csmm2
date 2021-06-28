<?php

namespace App\Api;

class Shipment extends CSM
{
    const FAILED = 0 ;
    const SUCCESS = 1 ;

    public $reference = "" ;
    public $description = "" ;
    public $isReturn = false ;
    public $labelType = "" ;
    public $parcelType = "" ;
    public $serviceCode = "" ;
    public $pickupDate = "" ; //yyyy-MM-dd
    public $emailNotification = null ;

    public $shipFrom = null ;
    public $shipTo = null ;

    private $parcels = [] ;

    public $invoice = null ;

    private $status = null ;
    private $message = null ;

    private $consigmentNumber = null ;
    private $trackingNumber = null ;
    private $labels = [] ;

    public function addParcel( $parcel ) {
        $this->parcels[] = $parcel ;
    }

    protected function toXML() {

        $xml = "<Request xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\">
                    <RequestAction>Ship</RequestAction>" ;

        $xml .= $this->account->toXML() ;

        $xml .= "<Consignment>
                    <Reference>".$this->reference."</Reference>
                    <Description>".$this->description."</Description>
                    <IsReturn>".($this->isReturn ? "true" : "false")."</IsReturn>
                    <LabelType>".$this->labelType."</LabelType>
                    <ParcelType>".$this->parcelType."</ParcelType>
                    <ServiceCode>".$this->serviceCode."</ServiceCode>
                    <PickupDate>".$this->pickupDate."</PickupDate>" ;

        if( $this->emailNotification )
        {
            $xml .= "<Notify>
                        <EmailAddress>".$this->emailNotification."</EmailAddress>
                        <Created>true</Created>
                        <InTransit>true</InTransit>
                        <Delivered>true</Delivered>
                        <Exception>true</Exception>
                     </Notify>" ;
        }

        /*
         <AdditionalOptions>
            <SignatureRequired></SignatureRequired>
            <AdultSignatureRequired></AdultSignatureRequired>
            <Duty>
                <DutiesAndTaxesPaidByShipper></DutiesAndTaxesPaidByShipper>
                <DutiableContents></DutiableContents>
            </Duty>
          </AdditionalOptions>
         */

        if( $this->shipFrom ) {
            $xml .= $this->shipFrom->toXml() ;
        }

        if( $this->shipTo ) {
            $xml .= $this->shipTo->toXml();
        }

        if( count($this->parcels) > 0 ) {
            foreach( $this->parcels as $parcel ) {
                $xml .= $parcel->toXml() ;
            }
        }

        if( $this->invoice ) {
            $xml .= $this->invoice->toXml();
        }

        $xml .= "</Consignment></Request>" ;

        return $xml ;
    }
    public function ship( $test = null, $debug = false ) {

        if( $test == null ) {
            $data = $this->request("Ship/", $debug);
        } else {
            if( $test === "error" ) {
                $data = file_get_contents('/home/csmco/public_html/media/csm/ShipError.xml');
            } else {
                $data = file_get_contents('/home/csmco/public_html/media/csm/ShipResponse.xml');
            }
        }

        if( $data ) {
            $xml = simplexml_load_string($data);

            $success = isset($xml->ResponseResult->ResponseCode) ? $xml->ResponseResult->ResponseCode : "00";

            if ($success == "01") {

                // get the consignment number
                $this->consigmentNumber = $xml->Consignment->ConsignmentNumber;

                // get the tracking number
                $this->trackingNumber = $xml->Consignment->TrackingNumber;

                // get the label
                foreach ($xml->Consignment->Parcel as $parcel) {
                    $label = new Label();
                    $label->setId($parcel->LabelRef);
                    $label->setData($parcel->LabelData);

                    $this->labels[] = $label;
                }

                $this->status = Shipment::SUCCESS;

            } else {
                $this->status = Shipment::FAILED;
                $this->message = $xml->ResponseResult->ResponseDescription;
            }
        } else {
            $this->status = Shipment::FAILED;
            $this->message = "No data returned from CSM.";
        }

    }

    public function getStatus() {
        return $this->status ;
    }

    public function getMessage() {
        return $this->message ;
    }

    public function getConsigmentNumber() {
        return $this->consigmentNumber ;
    }

    public function getTrackingNumber() {
        return $this->trackingNumber ;
    }

    public function getLabels() {
        return $this->labels ;
    }

    /**
     * We have a 30 character limit on address lines so need to split up correctly.
     * Rules are: if any lines over 30 then split to the next line and cascade but truncate the last line
     * @param $address
     * @param $line1
     * @param null $line2
     * @param null $line3
     */
    public function setAddressLines( $address, $line1, $line2 = null, $line3 = null) {
        $newline1 = $line1 ;
        if( strlen($line1) > 30 ) {
            $newline1 = substr($line1, 0, 30) ;
            $line2 = rtrim(substr($line1, 30) ." ".$line2) ;
        }

        $newline2 = $line2 ;
        if( strlen($line2) > 30 ) {
            $newline2 = substr($line2, 0, 30) ;
            $line3 = rtrim(substr($line2, 30) ." ".$line3) ;
        }

        $newline3 = $line3 ;
        if( strlen($line3) > 30 ) {
            $newline3 = substr($line3, 0, 30) ;
        }

        $address->address1 = $newline1 ;
        $address->address2 = $newline2 ;
        $address->address3 = $newline3 ;

        return $address ;
    }

}

