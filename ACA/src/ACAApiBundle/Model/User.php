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
    protected $last_name;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $first_name;
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
    public function getlast_name()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setlast_name($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getfirst_name()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setfirst_name($first_name)
    {
        $this->first_name = $first_name;
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
        if (empty($data['email']) || empty($data['last_name']) || empty($data['first_name'])) {
            return 'Missing required fields: "email", "last_name", "first_name"';
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
        if (empty($data['email']) && empty($data['last_name']) &&
                empty($data['first_name']) && empty($data['role'])) {
            return 'Request contained no valid field (e.g. "email", "last_name", "first_name", "role")';
        }

        // If the email isn't a valid email ...
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return '"Email" field contained an invalid email address';
        }

        return $data;
    }
}
