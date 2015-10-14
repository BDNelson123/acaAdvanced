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
     * @ORM\Column(type="string", length=255)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $mainImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $bedNumber;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $bathNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $askingPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $extras;

}
