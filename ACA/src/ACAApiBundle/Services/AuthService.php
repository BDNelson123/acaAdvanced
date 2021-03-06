<?php

namespace ACAApiBundle\Services;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthService
 * @package ACAApiBundle\Security
 */
class AuthService
{
    /**
     * @var DBCommon
     */
    public $db;

    /**
     * @param $db
     */
    public function setDb($db) {
        $this->db = $db;
    }

    /**
     * @param string $username
     * @return string
     */
    public function createToken($username)
    {
        // Token format: {timestamp}:{username}
        // Regexp pattern: /[0-9]+:[A-z]+/
        $username = $this->sanitize($username);
        $apikey = $this->encryptString(time() . ':' . $username);
        $this->stashKey($apikey, $username);
        return $apikey;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authenticateRequest(Request $request)
    {
        // The request must contain the header 'apikey
        $apiKey = $this->sanitize($request->headers->get('apikey'));
        if (!$apiKey) {
            return 'Expected header "apikey" missing';
        }

        // API key must be the current token for a user
        $username = $this->getUsernameForApiKey($apiKey);
        if (!$username) {
            return 'API key does not exist';
        }

        // Decrypt the apikey
        $decrypted = $this->decryptString($apiKey);

        // Decrypted key must be in the correct format
        if (!preg_match('/[0-9]+:[A-z]+/', $decrypted)) {
            return 'API key is invalid';
        }

        // ApiKey must have been created somewhat recently
        if (time() - explode(':', $decrypted)[0] > 3000) {
            return 'API key is outdated';
        }

        return false;
    }

    /**
     * @param string $string
     * @param string $key
     * @return string
     */
    private function encryptString($string, $key = "17708009FF00") {
        $encrypt = serialize($string);
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        $key = pack('H*', $key);
        $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
        $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
        return $encoded;
    }

    /**
     * @param string $string
     * @param string $key
     * @return bool|mixed|string
     */
    private function decryptString($string, $key = "17708009FF00") {
        $decrypt = explode('|', $string.'|');
        $decoded = base64_decode($decrypt[0]);
        $iv = base64_decode($decrypt[1]);
        if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
        $key = pack('H*', $key);
        $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
        $mac = substr($decrypted, -64);
        $decrypted = substr($decrypted, 0, -64);
        $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
        if($calcmac!==$mac){ return false; }
        $decrypted = unserialize($decrypted);
        return $decrypted;
    }

    /**
     * @param string $apikey
     * @param $username
     * @return bool
     */
    private function stashKey($apikey, $username) {
        $this->db->setQuery('UPDATE user SET apikey="' .$apikey. '" WHERE username="' .$username.'";');
        $this->db->query();

        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $apikey
     * @return bool
     */
    public function destroyKey($apikey) {
        $this->db->setQuery('UPDATE user SET apikey="" WHERE username="' .$this->sanitize($this->getUsernameForApikey($apikey)). '";');
        $this->db->query();

        if ($this->db->getSqlstate() === '00000') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $apikey
     * @return string|null
     */
    private function getUsernameForApikey($apikey) {
        $this->db->setQuery('SELECT username FROM user WHERE apikey="' . $apikey . '" LIMIT 1;');
        $this->db->query();
        if (!empty($this->db->loadObject())) {
            return $this->db->loadObject()->username;
        } else {
            return null;
        }
    }

    /**
     * @param string $apikey
     * @return integer|null
     */
    public function getUserIdForApikey($apikey) {
        $this->db->setQuery('SELECT id FROM user WHERE apikey="' .$this->sanitize($apikey). '" LIMIT 1;');
        $this->db->query();
        if (!empty($this->db->loadObject())) {
            return $this->db->loadObject()->id;
        } else {
            return null;
        }
    }

    /**
     * @param string $string
     * @return string
     */
    private function sanitize($string) {
        return str_replace(array(',','*','\\',';'), '', $string);
    }
}