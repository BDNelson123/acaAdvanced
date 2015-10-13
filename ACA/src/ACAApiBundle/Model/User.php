<?php

namespace ACAApiBundle\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

/**
 * Class User
 * Impelements UserInterface, EquitableInterface
 * @package ACAApiBundle\Model\User
 */
class User implements UserInterface, EquatableInterface
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
    protected $roles;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

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
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Required by Symfony UserInterface
     * (for some reason)
     */
    public function eraseCredentials()
    {
    }

    /**
     * Required by Symfony UserInterface
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
    /**
     * Validates a request to post a new User
     * @param Request $request
     * @return string|array
     */
    public static function validatePost(Request $request) {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Require the following fields
        if (empty($data['email']) || empty($data['username']) || empty($data['password'])) {
            return 'Missing required fields: "email", "username", "password"';
        }

        if (strlen($data['password']) > 64) {
            return 'Password must be 64 characters or fewer';
        }

        // Require a valid email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email must be a valid email address';
        }

        return $data;
    }

    /**
     * Validates a request to modify a User
     * @param Request $request
     * @return string|array
     */
    public static function validatePut(Request $request) {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Forbid the following fields to the Rest API
        if (isset($data['roles']) && isset($data['is_active']) &&
                isset($data['password']) && isset($data['id']) && isset($data['username'])) {
            return 'Request contained invalid or readonly fields';
        }

        if (!empty($data['password']) && (strlen($data['password']) > 64)) {
            return 'Password must be 64 characters or fewer';
        }

        // If an email field is put, the address given must be valid
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email must be a valid email address';
        }

        return $data;
    }

    /**
     * Validates a login attempt; like everything else here, it expects Json
     * @param Request $request
     * @return string|array
     */
    public static function validateLogin(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Require the following fields
        if (empty($data['username']) || empty($data['password'])) {
            return 'Missing required fields: "username", "password"';
        }

        // Password must be 64 characters or less
        if (strlen($data['password']) > 64) {
            return 'Password is incorrectly formated';
        }

        return $data;
    }

    /**
     * Clean up fields that the client shouldn't see
     * @param array|object
     * @return array|object
     */
    public static function cleanupForDisplay($data) {
        if (gettype($data) === 'array') {

            foreach($data as $d) {
                //unset($d->id);
                unset($d->password);
                unset($d->roles);
                unset($d->apikey);
            }

        } elseif (gettype($data) === 'object') {
            //unset($data->id);
            unset($data->password);
            unset($data->roles);
            unset($data->apikey);
        }
        return $data;
    }
}