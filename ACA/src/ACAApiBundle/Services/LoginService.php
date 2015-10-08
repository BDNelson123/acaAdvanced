<?php

namespace ACAApiBundle\Services;

use ACAApiBundle\Services\DBCommon;

/**
 * Class LoginService
 * @package ACAApiBundle\Services
 */
class LoginService
{
    /**
     * @var \ACAApiBundle\Services\DBCommon $db
     */
    protected $db;

    /**
     * @param \ACAApiBundle\Services\DBCommon $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    public function tryLogin($username, $encryptedPassword) {
        $query = 'SELECT * FROM user WHERE username="' .$username. '" AND password="' .$encryptedPassword . '" LIMIT 1;';
        $this->db->setQuery($query);
        $this->db->query();

        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }
}