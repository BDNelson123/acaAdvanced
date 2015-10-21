<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bid")
 */
class BidEntity extends ACABaseEntity
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
    protected $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $house_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bid_amount;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $bid_date;

    protected $fields = array('id', 'house_id', 'user_id', 'bid_amount', 'bid_date');




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
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of User Id
     *
     * @param mixed user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

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
     * Get the value of Bid Amount
     *
     * @return mixed
     */
    public function getBidAmount()
    {
        return $this->bid_amount;
    }

    /**
     * Set the value of Bid Amount
     *
     * @param mixed bid_amount
     *
     * @return self
     */
    public function setBidAmount($bid_amount)
    {
        $this->bid_amount = $bid_amount;

        return $this;
    }

    /**
     * Get the value of Bid Date
     *
     * @return mixed
     */
    public function getBidDate()
    {
        return $this->bid_date;
    }

    /**
     * Set the value of Bid Date
     *
     * @param mixed bid_date
     *
     * @return self
     */
    public function setBidDate($bid_date)
    {

        $this->bid_date = new \DateTime($bid_date);


        return $this;
    }

    /**
     * Get the value of Fields
     *
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the value of Fields
     *
     * @param mixed fields
     *
     * @return self
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

}
