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
     * Validates a User with all required fields
     * @param Request $request
     * @return string|array
     */
    public static function validatePost(Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // If it's missing needed fields ...
        if (empty($data['email']) || empty($data['lastname']) || empty($data['firstname'])) {
            return 'Missing required fields: "email", "lastname", "firstname"';
        }

        // If the email isn't a valid email ...
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return '"Email" field must contain a valid email address';
        }

        return $data;
    }

    /**
     * Validates a User with any valid field
     * @param Request $request
     * @return string|array
     */
    public static function validatePut(Request $request) {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // If it's missing needed fields ...
        if (empty($data['email']) && empty($data['lastname']) &&
                empty($data['firstname']) && empty($data['role'])) {
            return 'Request contained no valid field (e.g. "email", "lastname", "firstname", "role")';
        }

        // If the email isn't a valid email ...
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return '"Email" field contained an invalid email address';
        }

        return $data;
    }
}