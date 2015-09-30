<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\DBCommon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function getAction()
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

    public function showAction($slug)
    {
        /**
         * @var $db DBCommon
         */
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('SELECT * FROM user WHERE id = ' . $slug . ';');
        $db->query();
        $result = $db->loadObjectList();

        $response = new JsonResponse();
        $response->setData(array(
            'users' => $result
        ));

        return $response;
    }

    public function postAction(Request $request)
    {
        $data = $request->request->all();
        $email = $data['email'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];

        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('INSERT INTO user(email, firstname, lastname) VALUES("'.$email.'", "'.$firstname.'", "'.$lastname.'");');
        $db->query();

        $response = new JsonResponse();
        $response->setData(array(
            'new record ID' => $db->getLastInsertId()
        ));
        return $response;
    }
}


