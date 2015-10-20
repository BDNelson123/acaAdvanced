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
     * @param mixed $user_id
     */
    public function setuser_id($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $house_id
     */
    public function sethouse_id($house_id)
    {
        $this->house_id = $house_id;
    }

    /**
     * @param mixed $bid_amount
     */
    public function setbid_amount($bid_amount)
    {
        $this->bid_amount = $bid_amount;
    }

    /**
     * @param mixed $bid_date
     */
    public function setbid_date($bid_date)
    {
        $this->bid_date = $bid_date;
    }
}
