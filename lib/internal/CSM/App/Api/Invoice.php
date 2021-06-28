<?php

namespace App\Api;

class Invoice
{
    public $invoiceNumber = "" ;
    public $invoiceDate = "" ;
    public $currency = "" ;
    public $senderVATNumber = "" ;
    public $receiverVATNumber = "" ;
    public $termsOfSale = "" ;
    public $reasonForExport = "" ;
    public $soldTo = "" ;
    public $contactName = "" ;
    public $contactPhone = "" ;
    public $VATNumber = "" ;
    private $address = "" ;
    public $signature = "" ;
    public $signatureDate = "" ;

    public function setSoldToAddress( $address) {
        $this->address = $address ;
    }

    public function toXML() {

        $xml = "<CommercialInvoice>
                    <InvoiceNumber>".$this->shortDescription."</InvoiceNumber>
                    <InvoiceDate>".$this->ddetailedDescription."</InvoiceDate>
                    <Currency>".$this->composition."</Currency>
                    <SenderVATNumber>".$this->harmonisedCode."</SenderVATNumber>
                    <ReceiverVATNumber>".$this->unitValue."</ReceiverVATNumber>
                    <TermsOfSale>".$this->unitWeight."</TermsOfSale>
                    <ReasonForExport>".$this->quantity."</ReasonForExport>
                    <SoldTo>
                        <ContactName></ContactName>
                        <ContactPhone></ContactPhone>
                        <VATNumber></VATNumber>" ;

        $xml .= $this->address->toXml() ;

            $xml .="</SoldTo>
                    <Signature>".$this->countryOfOrigin."</Signature>
                    <SignatureDate></SignatureDate>
                 </CommercialInvoice>" ;

            return $xml ;
    }
}