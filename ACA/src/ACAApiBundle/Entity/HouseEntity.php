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
     * @ORM\Column(type="string", length=255)
     */
    protected $main_image;

    /**
     * @ORM\Column(type="decimal", scale=1)
     */
    protected $bed_number;

    /**
    * @ORM\Column(type="decimal", scale=1)
    */
    protected $bath_number;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $asking_price;

    /**
     * @ORM\Column(type="text")
     */
    protected $extras;

    protected $Fields = array('id', 'address', 'city', 'state', 'zipcode', 'main_image', 'bed_number', 'bath_number', 'asking_price', 'extras');

    public function getData()
    {
      $data = [];

      foreach ($this->Fields as $field) {
        $data[$field] = $this->$field;
      }

      return $data;
    }

}
