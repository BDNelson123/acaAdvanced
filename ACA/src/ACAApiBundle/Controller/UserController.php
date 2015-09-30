<?php

namespace ACAApiBundle\Controller;

use ACAApiBundle\DBCommon;
use ACAApiBundle\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package ACAApiBundle\Controller
 *
 */
class UserController extends Controller
{
    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function getAction()
    {

        /**
         * @var $db DBCommon
         */
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('SELECT * FROM user;');
        $db->query();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function showAction($slug)
    {
        /**
         * @var $db DBCommon
         */
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('SELECT * FROM user WHERE id = ' . $slug . ';');
        $db->query();
        $response = new JsonResponse();
        $response->setData($db->loadObjectList());
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('INSERT INTO user(email, firstname, lastname) VALUES("'.$email.'", "'.$firstname.'", "'.$lastname.'");');
        $db->query();
        $response = new JsonResponse();
        $response->setData(array(
            'Inserted record with ID' => $db->getLastInsertId()
        ));
        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function putAction($slug, Request $request) {

        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $firstname = $data['firstname'];
        $lastname = $data['lastname'];
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('UPDATE user SET email="'.$email.'", firstname="'.$firstname.'", lastname="'.$lastname.'" WHERE id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAction($slug) {
        $db = new DBCommon('127.0.0.1', 'root', 'root', 'acaAdvanced', 3306);
        $db->setQuery('DELETE FROM user WHERE id='.$slug.';');
        $db->query();
        $response = new Response();
        $response->setStatusCode(200);
        return $response;
    }
}
