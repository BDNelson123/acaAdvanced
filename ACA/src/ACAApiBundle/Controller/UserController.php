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
        $data = $this->get('rest_service')->get(null);
        if ($data) {
            $response = new JsonResponse();
            $response->setData($data);
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('Index request found no records');
        }
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function showAction($slug)
    {
        $data = $this->get('rest_service')->get($slug);
        if ($data) {
            $response = new JsonResponse();
            $response->setData($data);
        } else {
            $response = new Response;
            $response->setStatusCode(500)->setContent('Index request found no records');
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function postAction(Request $request)
    {
        $response = new Response;
        $data = User::validateRequest($request);
        if ($data) {
              $rest = $this->get('rest_service');
              if ($rest->post('user', array(
                  'firstname' => $data['firstname'],
                  'lastname' => $data['lastname'],
                  'email' => $data['email'] ))) {
                  $response->setStatusCode(200)->setContent('Posted new record to /user');
              } else {
                  $response->setStatusCode(500)->setContent('Query failed');
              }
        } else {
            $response->setStatusCode(403)->setContent('Invalid submission');
        }
        return $response;
    }

    /**
     * @param $slug
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function putAction($slug, Request $request) {
        $response = new Response();
        $data = User::validateRequest($request);
        if ($data) {
            $rest = $this->get('rest_service');
            if ($rest->put('user', $slug, array(
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'] )))
            {
                $response->setStatusCode(200)->setContent('Succesfully updated record ' .$slug);
            } else {
                $response->setStatusCode(500)->setContent('Query failed');
            }
        } else {
            $response->setStatusCode(403)->setContent('Invalid submission');
            // ... because the data in the request didn't validate
        }
        return $response;
    }

    /**
     * @param $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function deleteAction($slug)
    {
        $response = new Response();
        if ($this->get('rest_service')->delete('user', $slug)) {
            $response->setStatusCode(200)->setContent('Successfully deleted record ' . $slug);
        } else {
            $response->setStatusCode(500)->setContent('Query failed');
        }
        return $response;
    }
}
