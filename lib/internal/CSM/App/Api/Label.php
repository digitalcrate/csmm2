<?php

namespace App\Api;

class Label
{

    private $id = 0 ;
    private $data = 0 ;

    public function setId( $id ) {
        $this->id = $id;
    }

    public function setData( $data ) {
        $this->data = $data;
    }

    public function getId() {
        return $this->id ;
    }

    public function getData() {
        return $this->data ;
    }
}