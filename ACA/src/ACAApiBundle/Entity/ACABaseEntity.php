<?php

namespace ACAApiBundle\Entity;

class ACABaseEntity
{
    protected $bidFields = array('id', 'houseid', 'userid', 'bidamount', 'biddate');
    protected $houseFields = array('id', 'address', 'city', 'state', 'zipcode', 'main_image', 'bed_number', 'bath_number', 'asking_price', 'extras');

    /**
     *
     */
    public function getBidData()
    {
        $data =[];

        foreach($this->bidFields as $field) {
            $data[$field] = $this->{$field};
        }

        return $data;
    }

    /**
     *
     */
    public function getHouseData()
    {
        $data =[];

        foreach($this->houseFields as $field) {
            $data[$field] = $this->{$field};
        }

        return $data;
    }
}