<?php

namespace ACAApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class UserEntity
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
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $authkey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

}