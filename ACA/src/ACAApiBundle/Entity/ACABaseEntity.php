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
//        $data = ['user_id', 'house_id', 'bid_amount', 'bid_date'];
//        $this->setuser_id($data['user_id']);
//        $this->sethouse_id($data['house_id']);
//        $this->setbid_amount($data['bid_amount']);
          $insert = 'set' . Inflector::camelize($data);

        foreach($data as $field => $value) {


          $bid->setuser_id($data['user_id']);
          //            $bid->sethouse_id($data['house_id']);
          //            $bid->setbid_amount($data['bid_amount']);
          //            $bid->setbid_date($data['bid_date']);

                      $em->persist($bid);
                      $em->flush();
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
