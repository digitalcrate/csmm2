<?php

namespace App\Api;

class Product extends CSM
{

    public $shortDescription = "" ;
    public $detailedDescription = "" ;
    public $composition = "" ;
    public $harmonisedCode = "" ;
    public $unitValue = "" ;
    public $unitWeight = "" ;
    public $quantity = "" ;
    public $unitsOfMeasure = "" ;
    public $countryOfOrigin = "" ;

    public function toXML() {

        return "<Product>
                    <ShortDescription>".$this->shortDescription."</ShortDescription>
                    <DetailedDescription>".$this->ddetailedDescription."</DetailedDescription>
                    <Composition>".$this->composition."</Composition>
                    <HarmonisedCode>".$this->harmonisedCode."</HarmonisedCode>
                    <UnitValue>".$this->unitValue."</UnitValue>
                    <UnitWeight>".$this->unitWeight."</UnitWeight>
                    <Quantity>".$this->quantity."</Quantity>
                    <UnitsOfMeasure>".$this->unitsOfMeasure."</UnitsOfMeasure>
                    <CountryOfOrigin>".$this->countryOfOrigin."</CountryOfOrigin>
                 </Product>" ;
    }
}