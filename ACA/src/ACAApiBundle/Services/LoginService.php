<?php

namespace ACAApiBundle\Services;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginService
 * @package ACAApiBundle\Services
 */
class LoginService
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

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function tryLogin($username, $password) {

        $query = 'SELECT * FROM user WHERE username="' .$this->sanitize($username). '" AND password="' .$this->sanitize($password). '" LIMIT 1;';
        $this->db->setQuery($query);
        $this->db->query();
        return $this->db->loadObject();
    }

    /**
     * Validates a login attempt; like everything else here, it expects Json
     * @param Request $request
     * @return string|array
     */
    public function validateLogin(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // Expected: json
        if ($data === null) {
            return 'Expected content type: application/json';
        }

        // Require the following fields
        if (empty($data['username']) || empty($data['password']) ||
            !is_string($data['username']) || !is_string($data['password'])) {
            return 'Missing required fields: "username", "password"';
        }

        // Password must be 64 characters or less
        if (strlen($data['password']) > 64) {
            return 'Password is incorrectly formatted';
        }

        $data['password'] = $this->hashPassword($data['password']);
        return $data;
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