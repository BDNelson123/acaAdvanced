<?php

namespace ACAApiBundle\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package ACAApiBundle\Model\User
 */
class User
{
    /**
     * @var $id integer
     */
    protected $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $lastname;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $firstname;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $email;
    /**
     * @var string
     */
    protected $role;
    /**
     * @var string
     */
    protected $authkey;

    /**
     * @param $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getAuthkey()
    {
        return $this->authkey;
    }

    /**
     * @param mixed $authkey
     */
    public function setAuthkey($authkey)
    {
        $this->authkey = $authkey;
    }

    /**
     * If the Request is a json representing a valid User, function outputs the contents as an associative array
     * @param Request $request
     * @return bool|array
     */
    public static function validateRequest(Request $request) {
        $data = json_decode($request->getContent(), true);

        if (gettype($data) !== 'array') { return false; }

        if (empty($data['email']) || empty($data['lastname']) || empty($data['firstname'])) {
            return false;
        } else {
            return $data;
        }
    }
}