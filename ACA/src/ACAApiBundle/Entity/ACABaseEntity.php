<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Util\Inflector;

/**
 * @ORM\MappedSuperclass()
 */
class ACABaseEntity
{
    /**
     * @return array
     */
    public function getData()
    {
        $data =[];

        foreach($this->fields as $field) {
            $data[$field] = $this->{$field};
        }

        return $data;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
//        $data = ['userid', 'houseid', 'bidamount', 'biddate'];
//        $this->setUserId($data['userid']);
//        $this->setHouseId($data['houseid']);
//        $this->setBidAmount($data['bidamount']);

        foreach($data as $field => $value) {
            echo $field;
            echo $value;
        }

        return $data;
    }
}

/*
 * 1) $data->name == $data->{"name"}
 * 2) $variable = function;
 *      $variable();
 * 3) 
 */