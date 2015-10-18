<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="house")
 */
class HouseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $state;

    /**
     * @ORM\Column(type="integer", length=5)
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="blob")
     */
    protected $mainimage;

    /**
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $bednumber;

    /**
    * @ORM\Column(type="decimal", scale=1)
    */
    protected $bathnumber;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $askingprice;

    /**
     * @ORM\Column(type="text")
     */
    protected $extras;

    protected $fields = array('id', 'address', 'city', 'mainimage', 'bednumber', 'bathnumber', 'askingprice', 'extra');

    public function getData()
    {
      $data = [];

      foreach ($this->fields as $field) {
        $data[$field] = $this->$field;
      }

      return $data;
    }

}
