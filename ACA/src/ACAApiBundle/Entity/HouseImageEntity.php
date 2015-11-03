<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="houseimage")
 */
class HouseImageEntity extends ACABaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $house_id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $house_image_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $house_image;

    /**
     * @var array
     */
    protected $fields = array('id', 'house_id', 'house_image_date', 'house_image');

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of House Id
     *
     * @return mixed
     */
    public function getHouseId()
    {
        return $this->house_id;
    }

    /**
     * Set the value of House Id
     *
     * @param mixed house_id
     *
     * @return self
     */
    public function setHouseId($house_id)
    {
        $this->house_id = $house_id;

        return $this;
    }

    /**
     * Get the value of House Image Date
     *
     * @return mixed
     */
    public function getHouseImageDate()
    {
        return $this->house_image_date;
    }

    /**
     * Set the value of House Image Date
     *
     * @param mixed house_image_date
     *
     * @return self
     */
    public function setHouseImageDate($house_image_date)
    {
        $this->house_image_date = $house_image_date;

        $this->bid_date = new \DateTime($bid_date);

        return $this;
    }

    /**
     * Get the value of House Image
     *
     * @return mixed
     */
    public function getHouseImage()
    {
        return $this->house_image;
    }

    /**
     * Set the value of House Image
     *
     * @param mixed house_image
     *
     * @return self
     */
    public function setHouseImage($house_image)
    {
        $this->house_image = $house_image;

        return $this;
    }

    /**
     * Get the value of Fields
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the value of Fields
     *
     * @param array fields
     *
     * @return self
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}
