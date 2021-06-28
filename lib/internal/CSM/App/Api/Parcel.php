<?php

namespace App\Api;

class Parcel
{

    public $weight = 0 ;
    public $length = 0 ;
    public $width = 0 ;
    public $height = 0 ;

    private $products = [] ;

    public function __construct( $weight = 0, $length = 0, $width = 0, $height = 0)
    {
        $this->weight = $weight ;
        $this->length = $length ;
        $this->width = $width ;
        $this->height = $height ;
    }

    public function addProduct( $product ) {
        $this->products[] = $product ;
    }

    public function toXML() {

        $xml = "<Parcel>
                    <Weight>".number_format($this->weight, 2, ".", "")."</Weight>
                    <Dimensions>
                        <Length>".number_format($this->length, 2, ".", "")."</Length>
                        <Width>".number_format($this->width, 2, ".", "")."</Width>
                        <Height>".number_format($this->height, 2, ".", "")."</Height>
                    </Dimensions>" ;

                    if( count($this->products) > 0 ) {
                        $xml .= "<Products>" ;
                        foreach( $this->products as $product ) {
                            $xml .= $product->toXml() ;
                        }
                        $xml .= "</Products>" ;
                    }

                    $xml .= "</Parcel>" ;

                    return $xml ;
    }
}