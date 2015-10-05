<?php

namespace ACAApiBundle\Model;

/**
 * Class Bid
 * @package ACAApiBundle\Model\Bid
 */
class Bid
{
    protected $id;
    protected $userid;
    protected $houseid;
    protected $bidamount;
    protected $biddate;

    /**
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getBidAmount()
    {
        return $this->bidamount;
    }

    /**
     * @param mixed $bidamount
     */
    public function setBidAmount($bidamount)
    {
        $this->bidamount = $bidamount;
    }

    /**
     * @return mixed
     */
    public function getBidDate()
    {
        return $this->biddate;
    }

    /**
     * @param mixed $biddate
     */
    public function setBidDate($biddate)
    {
        $this->biddate = $biddate;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return mixed
     */
    public function gethouseid()
    {
        return $this->houseid;
    }

    /**
     * @param mixed $houseid
     */
    public function setHouseId($houseid)
    {
        $this->houseid = $houseid;
    }
}