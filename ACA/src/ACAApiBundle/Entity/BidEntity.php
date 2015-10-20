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
    protected $userid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $houseid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $bidamount;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $biddate;

    protected $fields = array('id', 'houseid', 'userid', 'bidamount', 'biddate');

    /**
     * @param mixed $userid
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @param mixed $houseid
     */
    public function setHouseId($houseid)
    {
        $this->houseid = $houseid;
    }

    /**
     * @param mixed $bidamount
     */
    public function setBidAmount($bidamount)
    {
        $this->bidamount = $bidamount;
    }

    /**
     * @param mixed $biddate
     */
    public function setBidDate($biddate)
    {
        $this->biddate = $biddate;
    }
}