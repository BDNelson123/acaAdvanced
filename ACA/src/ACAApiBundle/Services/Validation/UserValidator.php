<?php

namespace ACAApiBundle\Services\Validation;

use ACAApiBundle\Model\User;
use ACAApiBundle\Services\DBCommon;
use Symfony\Component\HttpFoundation\Request;

class UserValidator
{
    /**
     * @var DBCommon
     */
    protected $db;

    /**
     * @param DBCommon $db
     */
    public function setDb($db) {
        $this->db = $db;
    }

    public function validateRegister(Request $request) {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Require the following fields to exist and be fields
        if (!is_string($data['email']) || !is_string($data['username']) || !is_string($data['password'])) {
            return 'Missing required fields: "email", "username", "password"';
        }

        // Require username uniqueness
        if (!$this->checkUsernameUniqueness($data['username'])) {
            return 'Username must be unique';
        }

        // Enforce password length restriction
        if (!empty($data['password']) && (strlen($data['password']) > 64)) {
            return 'Password must be 64 characters or fewer';
        }

        // Require a valid email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email must be a valid email address';
        }

        $data['password'] = $this->hashPassword($data['password']);
        return $data;
    }

    /**
     * Validates a request to modify a User
     * @param Request $request
     * @return string|array
     */
    public function validatePut(Request $request) {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Forbid the following fields to the Rest API
        if (isset($data['roles']) || isset($data['is_active']) ||
            isset($data['id']) || isset($data['username'])) {
            return 'Request contained invalid or readonly fields';
        }

        // If an email field is put, the address given must be valid
        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Email must be a valid email address';
        }

        // If there's a password, hash it
        if (isset($data['password'])) {
            $data['password'] = $this->hashPassword($data['password']);
        }

        return $data;
    }

    /**
     * @param $username
     * @return bool
     */
    public function checkUsernameUniqueness($username) {
        $query = 'SELECT * FROM user WHERE username="' .$this->sanitize($username). '" LIMIT 1;';
        $this->db->setQuery($query);
        $this->db->query();

        if (!$this->db->loadObject()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    private function sanitize($string) {
        return str_replace(array(',','*','\\',';'), '', $string);
    }

    /**
     * @param $password
     * @return string
     */
    private function hashPassword($password) {
        return hash('sha512', $password, false);
    }
}