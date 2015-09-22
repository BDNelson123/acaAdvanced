<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\DBCommon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class UserController extends Controller
{
    public function indexAction()
    {
        /**
         * @var $db DBCommon
         */
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);

        $db->setQuery('SELECT * FROM user;');
        $db->query();
        $result = $db->loadObjectList();

        $response = new JsonResponse();
        $response->setData(array(
            'users' => $result
        ));

        return $response;
    }
}
