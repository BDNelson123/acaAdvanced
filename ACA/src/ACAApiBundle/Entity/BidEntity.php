<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bid")
 */
class BidEntity
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
}