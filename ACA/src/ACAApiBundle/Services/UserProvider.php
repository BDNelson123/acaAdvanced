<?php

namespace ACAApiBundle\Services;

use ACAApiBundle\Model\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Class UserProvider
 * @package ACAApiBundle\Services
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var DBCommon
     */
    protected $db;

    /**
     * @param DBCommon
     */
    public function setDb(DBCommon $db)
    {
        $this->db = $db;
    }

    /**
     * Required by UserProviderInterface
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {
        $this->db->setQuery('SELECT * FROM user WHERE username="' . str_replace(array(',','\\',';'), '', $username) . '" LIMIT 1;');
        $this->db->query();
        $data = $this->db->loadObject();

        if ($this->db->getSqlstate() === '00000') {
            $user = new User;
            $user->setUsername($data->username);
            $user->setPassword($data->password);
            $user->setFirstname($data->firstname);
            $user->setLastname($data->lastname);
            $user->setEmail($data->email);
            return $user;
        } else {
            throw new UsernameNotFoundException(sprintf('Could not load User '. $username . '; SQL state code: ' . $this->db->getSqlstate()));
        }
    }

    /**
     * Required by UserProviderInterface
     * @param UserInterface $user
     * @return User
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Required by UserProviderInterface
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'ACAApiBundle\Model\User';
    }
}